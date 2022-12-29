<?php
    session_start();
    $nextPage = "./medewerkerpaneel";
    if (isset($_SESSION["nextPage"])) {
        $nextPage = $_SESSION["nextPage"];
    }
    //ervoor zorgen dat gebruiker volgende keer niet weer geredirect kan worden, tenzij hier weer specifiek om gevraagd word.
    unset($_SESSION["nextPage"]);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/stylesheet.css">
    <link rel="stylesheet" href="/css/vluchtnummer_invoeren.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <title>Medewerker inloggen</title>
</head>

<body>
    <?php
        require_once "./components/navbar.php";
    ?>
    <div class="hero">
        <div class="hero-content">
            <h3>Log hier in met uw gebruikersnaam en wachtwoord</h3>
            <form method="post" action= <?= $nextPage ?> >
                <label for="gebruikersnaam">Gebruikersnaam:</label>
                <br>
                <input type="text" id="gebruikersnaam" name="gebruikersnaam" required>
                <br>
                <br>
                <label for="wachtwoord">Wachtwoord:</label>
                <br>
                <input type="password" name="wachtwoord" id="wachtwoord" required>
                <br>
                <input class="knop" type="submit" value="Inloggen">
            </form>
        </div>
    </div>
    <?php
        echo file_get_contents("./components/footer.html");
    ?>
</body>

</html>