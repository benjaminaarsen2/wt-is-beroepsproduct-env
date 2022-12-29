<?php
    session_start();
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

    <title>Vluchtgegevens ophalen</title>
</head>

<body>
    <?php
        require_once "./components/navbar.php";
    ?>
    <div class="hero">
        <div class="hero-content">
            <h3>Vul hier alstublieft het vluchtnummer in</h3>
            <form method="post" action="/vlucht_detail">
                <label for="vluchtnummer">Vluchtnummer:</label>
                <br>
                <input type="number" id="vluchtnummer" name="vluchtnummer">
                <br>
                <input class="knop" type="submit" value="Vluchtgegevens ophalen">
            </form>
        </div>
    </div>
    <?php
        echo file_get_contents("./components/footer.html");
    ?>
</body>

</html>