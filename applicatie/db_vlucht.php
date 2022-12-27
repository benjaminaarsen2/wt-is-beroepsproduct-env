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
            "select 'Gelre airport' as vertrekpunt, l.naam as bestemming, max_gewicht_pp as max_gewicht, max_aantal as aantal_plaatsen, (max_aantal - vp.vrije_plaatsen) as vrije_plaatsen,
            m.naam as vliegmaatschappij, v.vluchtnummer from Vlucht v
            inner join Luchthaven l on v.bestemming = l.luchthavencode
            inner join Maatschappij m on v.maatschappijcode = m.maatschappijcode
            inner join (select p.vluchtnummer as vluchtnummer, count(*) as vrije_plaatsen from Passagier p right join Vlucht v on p.vluchtnummer = v.vluchtnummer group by p.vluchtnummer) as vp
            on vp.vluchtnummer = v.vluchtnummer
            where v.vluchtnummer = (?)"
        );
        $query->execute([$vluchtnummer]);
        $res = $query->fetchAll()[0];
        return $res;
    }

    function haalAlleVluchtenBasisOp($sorteer = "vluchtnummer") {
        global $db;
        // we kunnen geen prepared statement gebruiken voor order by, maar op deze manier kunnen we wel SQL-injectie voorkomen
        if (!in_array($sorteer, ["vluchtnummer", "vertrektijd", "bestemming"])) {
            return false;
        }
        $query = $db->prepare(
            "select top 50 l.naam as bestemming, v.vertrektijd, m.naam as vliegmaatschappij, vluchtnummer from Vlucht v
            inner join Luchthaven l on v.bestemming = l.luchthavencode
            inner join Maatschappij m on v.maatschappijcode = m.maatschappijcode
            order by $sorteer"
        );
        $query->execute([$sorteer]);
        $res = $query->fetchAll();
        return $res;
    }
?>