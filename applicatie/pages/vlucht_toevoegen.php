<?php
    session_start();
     if(!isset($_SESSION["isMedewerker"])) {
        http_response_code(403);
        exit("<h1>Toegang geweigerd</h1>");
    }
    
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/stylesheet.css">
    <link rel="stylesheet" href="/css/inchecken.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <title>Vlucht toevoegen</title>
</head>

<body>
    <?php
        require_once "./components/navbar.php";
    ?>
    <!-- hero image -->
    <div class="hero">
        <div class="hero-content">
            <h3>Vul hier alstublieft de gegevens in</h3>
            <form class="inchecken" action="/vluchtgegevens_verifieren" method="post">

                <label for="vluchtnummer">Vluchtnummer:</label>
                <input type="number" name="vluchtnummer" id="vluchtnummer" required autofocus>

                <label for="bestemming">Bestemming (luchthavencode):</label>
                <input type="text" name="bestemming" id="bestemming" required>

                <label for="gatecode">Gatecode:</label>
                <input type="text" name="gatecode" id="gatecode" required>

                <label for="max_aantal">Max aantal personen:</label>
                <input type="number" name="max_aantal" id="max_aantal" required>

                <label for="max_gewicht_pp">Max gewicht per persoon:</label>
                <input type="number" name="max_gewicht_pp" id="max_gewicht_pp" required>

                <label for="max_totaalgewicht">Max gewicht totaal:</label>
                <input type="number" name="max_totaalgewicht" id="max_totaalgewicht" required>

                <label for="vertrektijd">Vertrektijd (y-m-d h:m:s.ms):</label>
                <input type="datetime" name="vertrektijd" id="vertrektijd" required>

                <label for="maatschappijcode">Maatschappijcode:</label>
                <input type="text" name="maatschappijcode" id="maatschappijcode" required>

                <input class="knop" type="submit" value="Vlucht Toevoegen">
            </form>
        </div>

    </div>
    <?php
        echo file_get_contents("./components/footer.html");
    ?>
</body>

</html>