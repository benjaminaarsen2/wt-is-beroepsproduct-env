<?php
    require_once "db_connectie.php";
    $db = maakVerbinding();

    // function haalVluchtOp($vluchtnummer) {
    //     global $db;
    //     $query = $db->prepare("SELECT vluchtnummer FROM Vlucht WHERE vluchtnummer = (?)");
    //     $query->execute([$vluchtnummer]);
    //     $res = $query->fetchAll()[0]["vluchtnummer"]
    // }
    
    function haalVrijePlaatsenOp($vluchtnummer) {
        global $db;
        $query = $db->prepare(
            "SELECT p.vluchtnummer, (v.max_aantal - count(*)) as vrije_plaatsen from Passagier p 
            inner join Vlucht v on v.vluchtnummer = (?)
            group by p.vluchtnummer, v.max_aantal"
            );
        $query->execute([$vluchtnummer]);
        $res = $query->fetchAll()[0]["vrije_plaatsen"];
        return $res;
    }

    function haalVluchtDetailOp($vluchtnummer) {
        global $db;
        $query = $db->prepare(
            "SELECT 'Gelre airport' as vertrekpunt, l.naam as bestemming, max_gewicht_pp as max_gewicht, max_aantal as aantal_plaatsen, (max_aantal - isnull(vp.vrije_plaatsen, 0)) as vrije_plaatsen,
            m.naam as vliegmaatschappij, v.vluchtnummer, m.maatschappijcode from Vlucht v
            inner join Luchthaven l on v.bestemming = l.luchthavencode
            inner join Maatschappij m on v.maatschappijcode = m.maatschappijcode
            left join (select p.vluchtnummer as vluchtnummer, count(*) as vrije_plaatsen from Passagier p right join Vlucht v on p.vluchtnummer = v.vluchtnummer group by p.vluchtnummer) as vp
            on vp.vluchtnummer = v.vluchtnummer
            where v.vluchtnummer = (?)" . (session_status() !== PHP_SESSION_NONE ? ((isset($_SESSION["passagiernummer"]) && !isset($_SESSION["mijnvlucht"])) ? " AND v.vertrektijd > GETDATE()" : "") : "")
        );
        $query->execute([$vluchtnummer]);
        unset($_SESSION["mijnvlucht"]);
        $res = $query->fetchAll();
        if (count($res) !== 1) {
            return false;
        }
        $res = $res[0];
        
        return $res;
    }

    function haalAlleVluchtenBasisOp($maatschappijfilter, $bestemmingfilter, $sorteer) {
        global $db;
        //voor het geval dat er geknutseld wordt met post requests
        if (!in_array($sorteer, ["vluchtnummer", "vertrektijd", "bestemming"])) {
            return false;
        }

        $filters = [];
        if($maatschappijfilter) {
            $filters["maatschappijfilter"] = $maatschappijfilter;
        }
        if($bestemmingfilter) {
            $filters["bestemmingfilter"] = $bestemmingfilter;
        }


        //ja dit is heel gaar, ik weet het, maar het scheelt een hoop code.
        $query = $db->prepare(
            "SELECT top 50 l.naam as bestemming, v.vertrektijd, m.naam as vliegmaatschappij, vluchtnummer, m.maatschappijcode from Vlucht v
            inner join Luchthaven l on v.bestemming = l.luchthavencode
            inner join Maatschappij m on v.maatschappijcode = m.maatschappijcode\n".
            (session_status() !== PHP_SESSION_NONE ? (!isset($_SESSION["isMedewerker"]) ? "WHERE v.vertrektijd > GETDATE() " : "WHERE (1 = 1) " ) : "WHERE (1=1) ").
            (array_key_exists("maatschappijfilter", $filters) && array_key_exists("bestemmingfilter", $filters)
                    ? "and m.naam = (?) and l.naam = (?)\n" 
                    : (array_key_exists("maatschappijfilter", $filters) 
                        ? "and m.naam = (?)\n"
                        : (array_key_exists("bestemmingfilter", $filters) 
                            ? "and l.naam = (?)\n" 
                            : ""
                        )
                    )
            ).
            "order by $sorteer"
        );
        $query->execute(array_values($filters));
        $res = $query->fetchAll();
        return $res;
    }

    function vluchtToevoegen($vluchtnummer, $bestemming, $gatecode, $max_aantal, $max_gewicht_pp 
    ,$max_totaalgewicht, $vertrektijd, $maatschappijcode) {
        global $db;

        $vertrektijd = date("y-m-d H:i:s", strtotime($vertrektijd));

        $query = $db->prepare(
            "SET dateformat ymd;".
            "INSERT INTO Vlucht (vluchtnummer, bestemming, gatecode, max_aantal, max_gewicht_pp, max_totaalgewicht, vertrektijd, maatschappijcode)
            VALUES (:vluchtnummer, :bestemming, :gatecode, :max_aantal, :max_gewicht_pp, :max_totaalgewicht, :vertrektijd, :maatschappijcode)"
        );
        $query->bindParam(":vluchtnummer", $vluchtnummer);
        $query->bindParam(":bestemming", $bestemming);
        $query->bindParam(":gatecode", $gatecode);
        $query->bindParam(":max_aantal", $max_aantal);
        $query->bindParam(":max_gewicht_pp", $max_gewicht_pp);
        $query->bindParam(":max_totaalgewicht", $max_totaalgewicht);
        $query->bindParam(":vertrektijd", $vertrektijd);
        $query->bindParam(":maatschappijcode", $maatschappijcode);

        try {
            $query->execute();
        }
        catch (PDOException $e) {
            error_log($e);
            return false;
        }
        return true;
    }
?>