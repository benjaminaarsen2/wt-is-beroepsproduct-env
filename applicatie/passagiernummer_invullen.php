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

    <title>Passagiernummer invullen</title>
</head>

<body>
    <?php
        echo file_get_contents("./components/navbar.html");
    ?>
    <div class="hero">
        <div class="hero-content">
            <h3>Vul hier alstublieft uw passagiernummer in</h3>
            <form method="post" action="/passagierpaneel.php">
                <label for="passagiernummer">Passagiernummer:</label>
                <br>
                <input type="number" id="passagiernummer" name="passagiernummer" required>
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