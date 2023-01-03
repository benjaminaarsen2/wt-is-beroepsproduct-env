<?php
    session_start();
    if(!isset($_SESSION["isMedewerker"])) {
        http_response_code(403);
        exit("<h1>Toegang geweigerd</h1>");
    }
    
    if (!isset($_SERVER["HTTP_REFERER"]) || parse_url($_SERVER["HTTP_REFERER"])["path"] !== "/vlucht_toevoegen") {
        http_response_code(403);
        exit("<h1>Toegang geweigerd</h1>");
    }
    require_once "./db/db_vlucht.php";

    $vluchtnummer      = isset($_POST["vluchtnummer"]) ? $_POST["vluchtnummer"] : false;
    $bestemming        = isset($_POST["bestemming"]) ? $_POST["bestemming"] : false;
    $gatecode          = isset($_POST["gatecode"]) ? $_POST["gatecode"] : false;
    $max_aantal        = isset($_POST["max_aantal"]) ? $_POST["max_aantal"] : false;
    $max_gewicht_pp    = isset($_POST["max_gewicht_pp"]) ? $_POST["max_gewicht_pp"] : false;
    $max_totaalgewicht = isset($_POST["max_totaalgewicht"]) ? $_POST["max_totaalgewicht"] : false;
    $vertrektijd       = isset($_POST["vertrektijd"]) ? $_POST["vertrektijd"] : false;
    $maatschappijcode  = isset($_POST["maatschappijcode"]) ? $_POST["maatschappijcode"] : false;

    // $inchecktijdstip = isset($_POST["inchecktijdstip"]) ? $_POST["inchecktijdstip"] : false;

    if($vluchtnummer && $bestemming && $gatecode && $max_aantal && $max_gewicht_pp 
        && $max_totaalgewicht && $vertrektijd && $maatschappijcode) {
        $res = vluchtToevoegen($vluchtnummer, $bestemming, $gatecode, $max_aantal, $max_gewicht_pp, $max_totaalgewicht, $vertrektijd, $maatschappijcode);
        if (!$res) {
            $_SESSION["error_reason"] = "U heeft verkeerde gegevens ingevuld wat een database-error opleverde.";
            header("Location: /ongeldig");
            exit();
        }

        $_SESSION["success_reason"] = "U heeft succesvol een vlucht aan het systeem toegevoegd";
        $_SESSION["nextPage"] = "/paneel_handler";
        header("Location: /success");
        exit();
    }
?>