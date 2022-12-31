<?php
    session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/stylesheet.css">
    <link rel="stylesheet" href="/css/inchecken.css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <title>Passagiergegevens invoeren</title>
</head>
<body>
    <?php
        require_once "./components/navbar.php";
    ?>
    <div class="hero">
        <div class="hero-content">
            <h3>Vul hier alstublieft de passagiersgegevens in</h3>
            <form class="inchecken" method="post" action= "./paneel_handler" >
                <label for="passagiernummer">Passagiernummer:</label>
                <input type="number" id="passagiernummer" name="passagiernummer" required autofocus>
                <label for="naam">Naam:</label>
                <input type="text" name="naam" id="naam" required>
                <label for="vluchtnummer">Vluchtnummer:</label>
                <input type="number" name="vluchtnummer" id="vluchtnummer" required>
                <label for="geslacht">Geslacht:</label>
                <span>
                    <input type="radio" name="geslacht" id="geslacht" value="M" checked>Man
                    <input type="radio" name="geslacht" id="geslacht" value="V">Vrouw
                    <input type="radio" name="geslacht" id="geslacht" value="x">Anders
                </span>
                <label for="balienummer">Balienummer:</label>
                <input type="number" name="balienummer" id="balienummer" required>
                <label for="stoel">Stoel:</label>
                <input type="text" name="stoel" id="stoel" required>
                <label for="inchecktijdstip">Inchecktijdstip:</label>
                <input type="datetime" name="inchecktijdstip" id="inchecktijdstip" required>
                <input class="knop" type="submit" value="Inloggen">
            </form>
        </div>
    </div>
    <?php
        echo file_get_contents("./components/footer.html");
    ?>
</body>
</html>