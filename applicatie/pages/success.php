<?php
    session_start();
    $reason = '';
    $nextPage = "./index";
    if (isset($_SESSION["nextPage"])) {
        $nextPage = $_SESSION["nextPage"];
    }
    if (isset($_SESSION["success_reason"])) {
        $reason = $_SESSION["success_reason"];
    }
    unset($_SESSION["success_reason"]);
    unset($_SESSION["nextPage"]);
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="/css/stylesheet.css">
    <link rel="stylesheet" href="/css/ongeldig.css">
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Gelre Airport</title>
</head>

<body>
    <?php
        require_once "./components/navbar.php";
    ?>

    <div class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Sucess</h1>
                <?= $reason ?>
            </div>
            <?= "<a class='knop' href=$nextPage>Terug</a>" ?>
        </div>

    </div>
    <?php
        echo file_get_contents("./components/footer.html");
    ?>
</body>

</html>