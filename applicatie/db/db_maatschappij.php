<?php
    require_once "db_connectie.php";
    $db = maakVerbinding();

    function haalMaatschappijenOp() {
        global $db;
        $query = $db->prepare("select naam from Maatschappij");
        $query->execute();
        $res = $query->fetchAll();

        return $res;
    }
?>