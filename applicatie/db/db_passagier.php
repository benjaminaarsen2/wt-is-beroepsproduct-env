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
            "select p.passagiernummer, m.max_objecten_pp as max_koffers, IIF(b.passagiernummer is not null, count(b.passagiernummer), 0) as koffers_ingecheckt from Passagier p
            left join BagageObject b on p.passagiernummer = b.passagiernummer
            inner join Vlucht v on p.vluchtnummer = v.vluchtnummer
            inner join Maatschappij m on v.maatschappijcode = m.maatschappijcode
            where p.passagiernummer = (?)
            group by p.passagiernummer, m.max_objecten_pp, b.passagiernummer"
        );
        $query->execute([$passagiernummer]);
        $res = $query->fetchAll()[0];
        return $res["max_koffers"] - $res["koffers_ingecheckt"] - $aantal_koffers; 
    }

    function koffersGewichtToegestaan($passagiernummer, $koffers_gewicht) {
        global $db;
        $query = $db->prepare(
            "select p.passagiernummer, max_gewicht_pp, isnull(sum(b.gewicht), 0) as passagier_gewicht from Passagier p
            inner join Vlucht v on p.vluchtnummer = v.vluchtnummer
            left join BagageObject b on p.passagiernummer = b.passagiernummer
            where p.passagiernummer = (?)
            group by p.passagiernummer, max_gewicht_pp"
        );
        $query->execute([$passagiernummer]);
        $res = $query->fetchAll()[0];
        return $res["max_gewicht_pp"] - $res["passagier_gewicht"] - $koffers_gewicht;
    }

    function passagierToevoegen($passagiernummer, $naam, $vluchtnummer, $geslacht, $balienummer, $stoel) {
        global $db;
        // $passagiernummer = str_pad($passagiernummer, 5, '0', STR_PAD_LEFT);
        $inchecktijdstip = date("y-m-d H:i:s");

        $query = $db->prepare(
            "SET dateformat ymd;".
            "INSERT INTO Passagier (passagiernummer, naam, vluchtnummer, geslacht, balienummer, stoel, inchecktijdstip) VALUES (:passagiernummer, :naam, :vluchtnummer, :geslacht, :balienummer, :stoel, :inchecktijdstip)"
        );
        $query->bindParam(':passagiernummer', $passagiernummer);
        $query->bindParam(':naam', $naam);
        $query->bindParam(':vluchtnummer', $vluchtnummer);
        $query->bindParam(':geslacht', $geslacht);
        $query->bindParam(':balienummer', $balienummer);
        $query->bindParam(':stoel', $stoel);
        $query->bindParam(':inchecktijdstip', $inchecktijdstip);
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