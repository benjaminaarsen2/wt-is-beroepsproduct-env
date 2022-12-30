<?php
    require_once "db_connectie.php";
    $db = maakVerbinding();

    // function haalVluchtOp($vluchtnummer) {
    //     global $db;
    //     $query = $db->prepare("SELECT vluchtnummer FROM Vlucht WHERE vluchtnummer = (?)");
    //     $query->execute([$vluchtnummer]);
    //     $res = $query->fetchAll()[0]["vluchtnummer"]
    // }

    function haalVluchtDetailOp($vluchtnummer) {
        global $db;
        $query = $db->prepare(
            "SELECT 'Gelre airport' as vertrekpunt, l.naam as bestemming, max_gewicht_pp as max_gewicht, max_aantal as aantal_plaatsen, (max_aantal - vp.vrije_plaatsen) as vrije_plaatsen,
            m.naam as vliegmaatschappij, v.vluchtnummer, m.maatschappijcode from Vlucht v
            inner join Luchthaven l on v.bestemming = l.luchthavencode
            inner join Maatschappij m on v.maatschappijcode = m.maatschappijcode
            inner join (select p.vluchtnummer as vluchtnummer, count(*) as vrije_plaatsen from Passagier p right join Vlucht v on p.vluchtnummer = v.vluchtnummer group by p.vluchtnummer) as vp
            on vp.vluchtnummer = v.vluchtnummer
            where v.vluchtnummer = (?)" . (session_status() !== PHP_SESSION_NONE ? (isset($_SESSION["passagiernummer"]) ? " AND v.vertrektijd > GETDATE()" : "") : "")
        );
        $query->execute([$vluchtnummer]);
        
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

        //default
        $query = $db->prepare(
            "select top 50 l.naam as bestemming, v.vertrektijd, m.naam as vliegmaatschappij, vluchtnummer, m.maatschappijcode from Vlucht v
            inner join Luchthaven l on v.bestemming = l.luchthavencode
            inner join Maatschappij m on v.maatschappijcode = m.maatschappijcode
            order by $sorteer"
        );

        if ($maatschappijfilter && $bestemmingfilter) {
            $query = $db->prepare(
                "select top 50 l.naam as bestemming, v.vertrektijd, m.naam as vliegmaatschappij, vluchtnummer, m.maatschappijcode from Vlucht v
                inner join Luchthaven l on v.bestemming = l.luchthavencode
                inner join Maatschappij m on v.maatschappijcode = m.maatschappijcode
                where m.naam = (?) and l.naam = (?)
                order by $sorteer
                "
            );
            $query->execute([$maatschappijfilter, $bestemmingfilter]);
            $res = $query->fetchAll();
            return $res;
        }
        else if ($maatschappijfilter) {
            $query = $db->prepare(
                "select top 50 l.naam as bestemming, v.vertrektijd, m.naam as vliegmaatschappij, vluchtnummer, m.maatschappijcode from Vlucht v
                inner join Luchthaven l on v.bestemming = l.luchthavencode
                inner join Maatschappij m on v.maatschappijcode = m.maatschappijcode
                where m.naam = (?)
                order by $sorteer
                "
            );
            $query->execute([$maatschappijfilter]);
            $res = $query->fetchAll();
            return $res;
        }
        else if ($bestemmingfilter) {
            $query = $db->prepare(
                "select top 50 l.naam as bestemming, v.vertrektijd, m.naam as vliegmaatschappij, vluchtnummer, m.maatschappijcode from Vlucht v
                inner join Luchthaven l on v.bestemming = l.luchthavencode
                inner join Maatschappij m on v.maatschappijcode = m.maatschappijcode
                where l.naam = (?)
                order by $sorteer
                "
            );
            $query->execute([$bestemmingfilter]);
            $res = $query->fetchAll();
            return $res;
        }
        
        $query->execute();
        $res = $query->fetchAll();
        return $res;
    }
?>