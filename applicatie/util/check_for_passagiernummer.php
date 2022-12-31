<?php
    require_once "./db/db_verify.php";

    function checkAndSetPassagiernummer($nextPage = "./passagierpaneel") {

        $passagiernummer = '';
        //als er een session is kunnen we hiervan het passagiernummer gebruiken
        if (isset($_SESSION["passagiernummer"])) {
            $passagiernummer = $_SESSION["passagiernummer"];
        }
        //als deze er niet is zorgen we dat we geredirect worden als er in post ook geen passagiernummer is
        else if (!isset($_POST["passagiernummer"])) {
            $_SESSION["nextPage"] = $nextPage;
            header("Location: ./passagiernummer_invullen");
            exit();
        }
        //er is wel een post passagiernummer beschikbaar dus gebruiken we deze.
        else {
            $passagiernummer = $_POST["passagiernummer"];
        }


        //checken of het passagiernummer niet langer is dan 5 karakters
        if (strlen($passagiernummer) !== 5) {
            $_SESSION["error_reason"] = "Het passagiernummer is niet 5 tekens lang.";
            header("Location: ./ongeldig");
            exit();
        }
        //passagiernummer omzetten naar integer.
        $passagiernummer = intval($passagiernummer);

        //checken of passagiernummer geldig is
        if (check_passagiernummer($passagiernummer) === false) {
            $_SESSION["error_reason"] = "Het ingevoerde passagiernummer bestaat niet.";
            header("Location: ./ongeldig");
            exit();
        }

        /* 
        Als het passagiernummer session variabele nog niet bestaat deze erin zetten,
        als de gebruiker een medewerker is moet dit niet want dan is hij volgens het systeem een medewerker
        en passagier tegelijkertijd
        */
        if(!isset($_SESSION["passagiernummer"]) && !isset($_SESSION["isMedewerker"])) {
            $_SESSION["passagiernummer"] = $passagiernummer;
        }
        return $passagiernummer;
    }
?>