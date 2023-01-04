<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/stylesheet.css">
    <link rel="stylesheet" href="./css/inchecken.css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Inchecken</title>
</head>

<body>
    <!-- navbar -->
    <?php
        require_once "./components/navbar.php";
    ?>
    <!-- hero image -->
    <div class="hero">
        <div class="hero-content">
            <form method="post" class="inchecken" action= <?= $_SERVER["REQUEST_URI"] ?> >
                <?php
                    for($i = 0; $i < intval($_SESSION["aantal_koffers"]); $i++) {
                        echo "<label for='gewicht-". $i . "'>Gewicht koffer ". $i+1 . "</label>";
                        echo "<input type='number' name='gewicht-". $i . "' id='gewicht-" . $i ."'>";
                    }
                ?>
                <input class="knop" type="submit" value="Inchecken">
            </form>
        </div>

    </div>
    <?php
        echo file_get_contents("./components/footer.html");
    ?>
</body>

</html>