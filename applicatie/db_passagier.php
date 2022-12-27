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
?>