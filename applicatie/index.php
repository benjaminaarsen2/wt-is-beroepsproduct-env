<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/stylesheet.css">
    <link rel="stylesheet" href="./css/home.css">
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Gelre Airport</title>
</head>

<body>
    <!-- navbar -->
    <?php
        include "./components/navbar.php";
    ?>
    <div class="hero">
        <main>
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Gelre airport</h1>
                    <h3>Bent u een passagier of medewerker?</h3>
                </div>
                <div class="knoppen">
                    <a href="./passagierpaneel.php" class="knop">Passagier</a>
                    <a href="./inloggen.html" class="knop">Medewerker</a>
                </div>
            </div>
        </main>
    </div>
    <!-- footer -->
    <?php
        echo file_get_contents("./components/footer.html");
    ?>
</body>

</html>