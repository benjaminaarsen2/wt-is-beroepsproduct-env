<?php
    require_once "db_connectie.php";
    $db = maakVerbinding();

    function haalNaamOp($passagiernummer) {
        global $db;
        $query = $db->prepare("SELECT naam FROM Passagier WHERE passagiernummer = (?)");
        $query->execute([$passagiernummer]);
        $res = $query->fetchAll()[0]["naam"];
        return $res;
    }

    function haalMijnVluchtOp($passagiernummer) {
        global $db;
        $query = $db->prepare("SELECT vluchtnummer FROM Passagier WHERE passagiernummer = (?)");
        $query->execute([$passagiernummer]);
        $res = $query->fetchAll()[0]["vluchtnummer"];
        return $res;
    }

    function koffersAantalToegestaan($passagiernummer, $aantal_koffers) {
        global $db;
        $query = $db->prepare(
            "select p.passagiernummer, m.max_objecten_pp as max_koffers, count(*) as koffers_ingecheckt from Passagier p
            inner join BagageObject b on p.passagiernummer = b.passagiernummer
            inner join Vlucht v on p.vluchtnummer = v.vluchtnummer
            inner join Maatschappij m on v.maatschappijcode = m.maatschappijcode
            where p.passagiernummer = (?)
            group by p.passagiernummer, m.max_objecten_pp"
        );
        $query->execute([$passagiernummer]);
        $res = $query->fetchAll()[0];
        return $res["max_koffers"] - $res["koffers_ingecheckt"] - $aantal_koffers; 
    }

    function koffersGewichtToegestaan($passagiernummer, $koffers_gewicht) {
        global $db;
        $query = $db->prepare(
            "select p.passagiernummer, max_gewicht_pp, sum(b.gewicht) as passagier_gewicht from Passagier p
            inner join Vlucht v on p.vluchtnummer = v.vluchtnummer
            inner join BagageObject b on p.passagiernummer = b.passagiernummer
            where p.passagiernummer = (?)
            group by p.passagiernummer, max_gewicht_pp"
        );
        $query->execute([$passagiernummer]);
        $res = $query->fetchAll()[0];
        return $res["max_gewicht_pp"] - $res["passagier_gewicht"] - $koffers_gewicht;
    }   
?>