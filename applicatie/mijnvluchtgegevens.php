<?php
    session_start();
    require_once "./db_verify.php";

    if (!isset($_SESSION["passagiernummer"])) {
        header("Location: ./passagiernummer_invullen.php");
        exit();
    }
    else if (!check_passagiernummer($_SESSION["passagiernummer"])) {
        $_SESSION["error_reason"] = "Het ingevoerde passagiernummer bestaat niet.";
        header("Location ./ongeldig.php");
        exit();
    }

    require_once "./db_passagier.php";
    $vluchtnummer = haalMijnVluchtOp($_SESSION["passagiernummer"]);

    $_SESSION["vluchtnummer"] = $vluchtnummer;
    header("Location: ./vlucht_detail.php");
    exit();
?>
