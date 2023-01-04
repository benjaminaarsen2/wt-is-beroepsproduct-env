<?php
    session_start();
    require_once "./db/db_verify.php";
    require_once "./util/check_for_passagiernummer.php";
    $passagiernummer = checkAndSetPassagiernummer($_SERVER["REQUEST_URI"]);
   

    require_once "./db/db_passagier.php";
    $vluchtnummer = haalMijnVluchtOp($passagiernummer);

    $_SESSION["vluchtnummer"] = $vluchtnummer;
    $_SESSION["mijnvlucht"] = true;
    header("Location: ./vlucht_detail");
?>
