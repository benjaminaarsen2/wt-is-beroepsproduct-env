<?php

    /*
    TODO: eerst een prompt met hoeveel koffers echoen, dit opslaan als session variabele en de pagina reloaden. 
    op basis van de hoeveelheid koffers in session het juiste aantal invoervelden echoen. Ook checken hoeveel koffers
    de passagier uberhaupt nog mag inchecken en een foutmelding geven als dit het maximum overshcrijdt qua 
    gewicht op de vlucht of aantal bagageobjecten per passagier
    */

    session_start();
    require_once "./check_for_passagiernummer.php";
    require_once "./db_passagier.php";


    $passagiernummer = checkAndSetPassagiernummer($_SERVER["REQUEST_URI"]); //na inloggen omleiden naar deze pagina.
    
    // if (!isset($_POST["aantal_koffers"])) {
    //     $_SESSION["inchecken_state"] = 'aantal_koffers_invoeren';
    // }

    IF (!isset($_SESSION["inchecken_state"])) { 
        $_SESSION["inchecken_state"] = "aantal_koffers_invoeren";
    }

    switch ($_SESSION["inchecken_state"]) {
        case "aantal_koffers_invoeren":
            //display aantal koffers prompt
            ob_start();
            require "./components/aantal_koffers_prompt.php";
            $out1 = ob_get_clean();
            echo $out1;

            //update state
            $_SESSION["inchecken_state"] = "aantal_koffers_checken";

            exit();
            break;
        case "aantal_koffers_checken":
            /*
            er wordt in de form al gehandhaafd op minimaal 1 koffer maar voor het geval dat er met post requests
            gespeeld gaat worden checken we het toch nog even.
            */
            $aantal_koffers = $_POST["aantal_koffers"];
            if ($aantal_koffers < 1) {
                $_SESSION["error_reason"] = "U heeft een ongeldig aantal koffers proberen op te geven, selecteer minimaal 1 koffer.";
            }


            //checken of de passagier dit aantal koffers wel kan inchecken
            $kofferstoegestaan = koffersAantalToegestaan($passagiernummer, $aantal_koffers);

            // max_toegestaan - koffers_al_ingecheckt - $aantal_koffers. < 0 betekent dat we over het limiet gaan.
            if ($kofferstoegestaan < 0) {
                if($kofferstoegestaan + $aantal_koffers === 0) {
                    $_SESSION["error_reason"] = "U heeft het limiet van aantal koffers bereikt en kan er geen meer inchecken.";
                }
                else {
                    $_SESSION["error_reason"] = "U probeerde te veel koffers in te checken, u kan nog maar " . 
                                                $kofferstoegestaan + $aantal_koffers . 
                                                " koffer".
                                                ($kofferstoegestaan + $aantal_koffers === 1 ? '' : 's').
                                                " inchecken.";
                }
                // we moeten terug naar de vorige state aangezien er nu een foute waarde ingevoerd is.
                $_SESSION["inchecken_state"] = "aantal_koffers_invoeren";
                header("Location: ./ongeldig.php");
                exit();
            }
            $_SESSION["inchecken_state"] = "aantal_gewicht_invoeren";
            $_SESSION["aantal_koffers"] = $aantal_koffers;
            header("Location: " . $_SERVER["REQUEST_URI"]);
            break;
        case "aantal_gewicht_invoeren":
            ob_start();
            require "./components/aantal_gewicht_prompt.php";
            $out1 = ob_get_clean();
            echo $out1;
            
            $_SESSION["inchecken_state"] = "aantal_gewicht_checken";
            exit();
            break;
        case "aantal_gewicht_checken":
            $gewicht = 0;
            foreach($_POST as $k => $v) {
                $gewicht += $v;
            }
            $gewichttoegestaan = koffersGewichtToegestaan($passagiernummer, $gewicht);

            // als we het maximale gewicht overschrijden
            if ($gewichttoegestaan < 0) {
                $_SESSION["error_reason"] = "Uw baggage overschrijdt het maximale gewicht per persoon voor deze vlucht. 
                                            U zit " . abs($gewichttoegestaan) . " boven het maximum.";
                // we moeten terug naar de vorige state aangezien er nu een foute waarde ingevoerd is.
                $_SESSION["inchecken_state"] = "aantal_gewicht_invoeren";
                header("Location: ./ongeldig.php");
                exit();
            }
            //TODO: koffers uploaden naar database
            $_SESSION["nextPage"] = "./paneel_handler.php";
            //TODO: gebruiker nog een overzicht van gegevens geven zodat hij kan checken of alles juist is
            $_SESSION["success_reason"] = "Uw bagage is successvol ingecheckt.";
            unset($_SESSION["inchecken_state"]);
            header("Location: ./success.php");
            break;
    }

?>