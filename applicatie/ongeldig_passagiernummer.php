<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="/css/stylesheet.css">
    <link rel="stylesheet" href="/css/success.css">
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Gelre Airport</title>
</head>

<body>
    <?php
        echo file_get_contents("./components/navbar.html");
    ?>

    <div class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <!-- TODO: moet hier een main tag omheen? -->
                <h1>Fout</h1>
                <h3>U heeft een ongeldig passagiernummer ingevuld, klik op onderstaande knop om terug te gaan.</h3>
            </div>
            <a class="knop" href="./passagiernummer_invullen.php">Passagiernummer invullen</a>
        </div>

    </div>
    <?php
        echo file_get_contents("./components/footer.html");
    ?>
</body>

</html>