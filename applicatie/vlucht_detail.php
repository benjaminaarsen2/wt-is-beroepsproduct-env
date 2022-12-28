<?php
    session_start();
    if(!isset($_POST["vluchtnummer"]) && !isset($_SESSION["vluchtnummer"]) && !isset($_GET["vluchtnummer"])) {
        $_SESSION["error_reason"] = "Er is geen vluchtnummer meegegeven";
        header("Location: ./ongeldig.php");
        exit();
    }
    
    $vluchtnummer = isset($_POST["vluchtnummer"]) 
                    ? $_POST["vluchtnummer"] 
                    : (
                        isset($_SESSION["vluchtnummer"])
                        ? $_SESSION["vluchtnummer"]
                        : $_GET["vluchtnummer"]
                    );

    if (strlen($vluchtnummer) !== 5) {
        $_SESSION["error_reason"] = "Het vluchtnummer moet 5 tekens lang zijn";
        header("Location: ./ongeldig.php");
        exit();
    }
    require_once "./db/db_verify.php";
    if (!check_vlucht($vluchtnummer)) {
        $_SESSION["error_reason"] = "Het vluchtnummer bestaat niet";
        header("Location: ./ongeldig.php");
        exit();
    }

    require_once "./db/db_vlucht.php";
    $vlucht_details = haalVluchtDetailOp($vluchtnummer);

    unset($_SESSION["vluchtnummer"]);
    $terugPagina = "./paneel_handler.php";
    if (isset($_GET["vluchtnummer"])) {
        $terugPagina = $_SERVER["HTTP_REFERER"];
    }

    $imagepath = "./img/". $vlucht_details["maatschappijcode"]. ".jpg";
    $imagefile = file_exists($imagepath) ? $imagepath : "./img/default.jpg";
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/stylesheet.css">
    <link rel="stylesheet" href="./css/vlucht_detail.css">
    <title>Vlucht details</title>
</head>
<body>
    <?php
        require_once "./components/navbar.php" ;
    ?>
    <div class="hero">
        <div class="hero-content">
            <div class="vluchtinfo">
                <h3 class="label">Vertrekpunt:</h3>
                <?= "<h3>". $vlucht_details["vertrekpunt"]. "</h3>" ?>
                <h3 class="label">Bestemming:</h3>
                <?= "<h3>". $vlucht_details["bestemming"]. "</h3>" ?>
                <h3 class="label">Max gewicht:</h3>
                <?= "<h3>". $vlucht_details["max_gewicht"]. "</h3>" ?>
                <h3 class="label">Aantal plaatsen:</h3>
                <?= "<h3>". $vlucht_details["aantal_plaatsen"]. "</h3>" ?>
                <h3 class="label">Aantal vrije plaatsen:</h3>
                <?= "<h3>". $vlucht_details["vrije_plaatsen"]. "</h3>" ?>
                <h3 class="label">Vliegmaatschappij:</h3>
                <?= "<h3>". $vlucht_details["vliegmaatschappij"]. "</h3>" ?>
                <h3 class="label">Vluchtnummer:</h3>
                <?= "<h3>". $vlucht_details["vluchtnummer"]. "</h3>" ?>
                <img alt="KLM Vliegtuig" src= <?= $imagefile ?> >
                <a class="knop" href= <?=$terugPagina?> >Terug</a>
            </div>
        </div>
    </div>
    <?php
        echo file_get_contents("./components/footer.html");
    ?>
</body>
</html>