<?php
    session_start();

    if(isset($_SESSION["isMedewerker"]) && $_SESSION["isMedewerker"] === true) {
        header("Location: ./medewerkerpaneel.php");
        exit();
    }
    else {
        header("Location: ./passagierpaneel.php");
        exit();
    }
?>