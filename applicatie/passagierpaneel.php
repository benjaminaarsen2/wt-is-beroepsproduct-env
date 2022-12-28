<?php
    session_start();
    require_once "./check_for_passagiernummer.php";
    $passagiernummer = checkAndSetPassagiernummer(); //geen nextPage want default is passagierpaneel.

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
        require_once "./components/navbar.php";
    ?>
    <header>
        <?= "<h1>Ingelogd als: $passagier_naam</h1>"?>
    </header>
    <div class="hero">
        <div class="hero-content">
            <a href="./vluchtgegevens_ophalen.php" class="knop">Vluchtgegevens ophalen</a>
            <a href="./inchecken.php" class="knop">Inchecken</a>
            <a href="./mijnvluchtgegevens.php" class="knop">Mijn vluchtgegevens</a>
        </div>
    </div>
    <?php
        echo file_get_contents("./components/footer.html");
    ?>
</body>

</html>