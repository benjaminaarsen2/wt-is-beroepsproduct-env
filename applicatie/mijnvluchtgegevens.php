<?php
    session_start();
    require_once "./db_verify.php";
    require_once "./check_for_passagiernummer.php";
    $passagiernummer = checkAndSetPassagiernummer($_SERVER["REQUEST_URI"]);
   

    require_once "./db_passagier.php";
    $vluchtnummer = haalMijnVluchtOp($passagiernummer);

    $_SESSION["vluchtnummer"] = $vluchtnummer;
    header("Location: ./vlucht_detail.php");
?>
