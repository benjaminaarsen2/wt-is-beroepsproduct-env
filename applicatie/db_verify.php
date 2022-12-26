<?php
    require_once "./db_connectie.php";
    $db = maakVerbinding();

    function check_passagiernummer($passagiernummer) {
        global $db;
        $query = $db->prepare("SELECT passagiernummer FROM Passagier WHERE passagiernummer = (?)");
        $query->execute([$passagiernummer]);
        $res = $query->fetchAll();
        if (count($res) === 1) {
            return true;
        }
        else {
            return false;
        }
    }
?>  