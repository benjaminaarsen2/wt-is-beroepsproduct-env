<?php
    session_start();
    if(!isset($_SESSION["isMedewerker"])) {
        http_response_code(403);
        exit("<h1>Toegang geweigerd</h1>");
    }
    
    if (!isset($_SERVER["HTTP_REFERER"]) || parse_url($_SERVER["HTTP_REFERER"])["path"] !== "/passagiergegevens_invullen") {
        http_response_code(403);
        exit("<h1>Toegang geweigerd</h1>");
    }
    require_once "./db/db_passagier.php";

    $passagiernummer = isset($_POST["passagiernummer"]) ? $_POST["passagiernummer"] : false;
    $naam            = isset($_POST["naam"]) ? $_POST["naam"] : false;
    $vluchtnummer    = isset($_POST["vluchtnummer"]) ? $_POST["vluchtnummer"] : false;
    $geslacht        = isset($_POST["geslacht"]) ? $_POST["geslacht"] : false;
    $balienummer     = isset($_POST["balienummer"]) ? $_POST["balienummer"] : false;
    $stoel           = isset($_POST["stoel"]) ? $_POST["stoel"] : false;
    // $inchecktijdstip = isset($_POST["inchecktijdstip"]) ? $_POST["inchecktijdstip"] : false;

    if ($passagiernummer && $naam && $vluchtnummer && $geslacht && $balienummer && $stoel) {
        $res = passagierToevoegen($passagiernummer, $naam, $vluchtnummer, $geslacht, $balienummer, $stoel);

        if (!$res) {
            $_SESSION["error_reason"] = "U heeft verkeerde gegevens ingevuld wat een database-error opleverde.";
            header("Location: /ongeldig");
            exit();
        }

        $_SESSION["success_reason"] = "U heeft succesvol een passagier aan het systeem toegevoegd";
        $_SESSION["nextPage"] = "/paneelhandler";
        header("Location: /success");
        exit();
    }
?>