<?php
    session_start();

    $passagiernummer = '';

    //als er een session is kunnen we hiervan het passagiernummer gebruiken
    if (session_status() !== PHP_SESSION_NONE && isset($_SESSION["passagiernummer"])) {
        $passagiernummer = $_SESSION["passagiernummer"];
    }
    //als deze er niet is zorgen we dat we geredirect worden als er ook geen passagiernummer is
    else if (!isset($_POST["passagiernummer"])) {
        header("Location: ./passagiernummer_invullen.php");
        exit();
    }
    //er is wel een post passagiernummer beschikbaar dus gebruiken we deze.
    else {
        $passagiernummer = $_POST["passagiernummer"];
    }

    //checken of het passagiernummer niet langer is dan 5 karakters
    if (strlen($passagiernummer) !== 5) {
        header("Location: ./ongeldig_passagiernummer.php");
        exit();
    }
    //passagiernummer omzetten naar integer.
    $passagiernummer = intval($passagiernummer);
    require_once "./db_verify.php";
    //checken of passagiernummer geldig is
    if (check_passagiernummer($passagiernummer) === false) {
        header("Location: ./ongeldig_passagiernummer.php");
        exit();
    }

    //session starten met passagiernummer
    $_SESSION["passagiernummer"] = $passagiernummer;

    // Als we dit punt kunnen bereiken betekent het dat er een geldig passagiersnummer ingevuld is.
    require_once "./db_passagier.php";
    $passagier_naam = haalNaamOp($passagiernummer);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/stylesheet.css">
    <link rel="stylesheet" href="./css/paneel.css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Passagier paneel</title>
</head>

<body>
    <!-- navbar -->
    <?php
        echo file_get_contents("./components/navbar.html");
    ?>
    <header>
        <?= "<h1>Ingelogd als: $passagier_naam</h1>"?>
        <!-- <h1>Passagier paneel</h1> -->
    </header>
    <div class="hero">
        <div class="hero-content">
            <a href="./vluchtgegevens_ophalen.php" class="knop">Vluchtgegevens ophalen</a>
            <a href="./inchecken.html" class="knop">Inchecken</a>
            <a href="./vluchten_passagier.html" class="knop">Mijn vluchtgegevens</a>
        </div>
    </div>
    <?php
        echo file_get_contents("./components/footer.html");
    ?>
</body>

</html>