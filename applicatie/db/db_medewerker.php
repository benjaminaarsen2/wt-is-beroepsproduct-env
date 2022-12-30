<?php
    require_once "db_connectie.php";

    $db = maakVerbinding();


    function checkMedewerkerLogin($gebruikersnaam, $wachtwoord) {
        global $db;
        
        $query = $db->prepare("
        SELECT naam, password FROM medewerkers where naam = (?)
        ");
        $query->execute([$gebruikersnaam]);
        $res = $query->fetchAll();
        if (count($res) !== 1) {
            return false;
        }
        
        $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);
        //wachtwoord is fout
        if (!password_verify($wachtwoord, $res[0]["password"])) {
            return false;
        }

        return true;
    }
?>  