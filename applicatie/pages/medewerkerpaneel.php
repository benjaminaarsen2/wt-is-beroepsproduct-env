<?php
    session_start();

    if (!isset($_SESSION["isMedewerker"])) {
        header("Location: ". "./medewerker_login");
        exit();
    }

?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/stylesheet.css">
    <link rel="stylesheet" href="./css/medewerkerpaneel.css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Medewerker paneel</title>
</head>

<body>
    <?php
        require_once "./components/navbar.php";
    ?>
    <header>
        <h1>Medewerker paneel</h1>
    </header>
    <div class="hero">
        <div class="hero-content">
            <a href="./vluchtgegevens_ophalen_medewerker.html" class="knop">Vluchtgegevens ophalen</a>
            <a href="./passagier_inchecken.html" class="knop">Passagier inchecken</a>
            <a href="./passagier_toevoegen.html" class="knop">Passagier toevoegen</a>
            <a href="./vlucht_toevoegen.html" class="knop">Vlucht toevoegen</a>
        </div>
    </div>
    <?php
        echo file_get_contents("./components/footer.html");
    ?>
</body>

</html>