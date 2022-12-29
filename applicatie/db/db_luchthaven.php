<?php
    require_once "db_connectie.php";
    $db = maakVerbinding();

    function haalLuchthavensOp() {
        global $db;
        $query = $db->prepare("select naam from luchthaven");
        $query->execute();
        $res = $query->fetchAll();

        return $res;
    }
?>