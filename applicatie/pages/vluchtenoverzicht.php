<?php
    session_start();
    require_once "./db/db_vlucht.php";
    $sorteer = isset($_POST["sorteer"]) ? $_POST["sorteer"] : 'vluchtnummer';
    $maatschappijfilter = isset($_POST["maatschappij"]) ? $_POST["maatschappij"] : false;
    $bestemmingfilter = isset($_POST["bestemming"]) ? $_POST["bestemming"] : false;

    $vluchten = haalAlleVluchtenBasisOp($maatschappijfilter, $bestemmingfilter, $sorteer);

    // De functie returnt false als de sorteermethode anders is dan in code mogelijk, 
    // wat betekent dat er SQL-injectie plaats heeft gevonden
    if ($vluchten === false) {
        echo "<h2>Not this time, bitch</h2>";
        exit();
    }
    require_once "./db/db_maatschappij.php";
    $maatschappijen = haalMaatschappijenOp();
    
    require_once "./db/db_luchthaven.php";
    $luchthavens = haalLuchthavensOp();
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/stylesheet.css">
    <link rel="stylesheet" href="/css/vluchtenoverzicht.css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <title>Vluchtenoverzicht</title>
</head>

<body>
    <?php
        require_once "./components/navbar.php";
    ?>
    <header>
        <h1>Vluchtenoverzicht</h1>
    </header>
    <div class="filterbar">
        <form class="filters" action="./vluchtenoverzicht" method="post" id="filters">
            <h2>Fitlers</h2>
            <div class="filter">
                <label for="maatschappij">Maatschappij:</label>
                <select name="maatschappij" id="maatschappij" form="filters">
                    <option value="none" selected disabled hidden></option>
                    <?php
                        foreach($maatschappijen as $a) {
                            echo "<option value= '".$a["naam"]. "'>" . $a["naam"] . "</option>";
                        }
                    ?>
                </select>
                <label for="bestemming">Bestemming:</label>
                <select name="bestemming" id="bestemming">
                    <option value="none" selected disabled hidden></option>
                    <?php
                        foreach($luchthavens as $a) {
                            echo "<option value= '".$a["naam"]. "'>" . $a["naam"] . "</option>";
                        }
                    ?>
                </select>
            </div>
            <input class="knop" type="submit" value="Filters toepassen">
        </form>
    </div>
    <div class="hero">
        <!-- TODO: sorteer dropdown: tijd, luchthaven -->
        <form action="./vluchtenoverzicht" method="post" class="sortmenu">
            <input class="sortbtn" type="submit" value="vertrektijd" name="sorteer">
            <input class="sortbtn" type="submit" value="bestemming" name="sorteer">
        </form>
        <div class="vluchten">
            <?php
                foreach($vluchten as $vlucht) {
                    echo "<a class='vlucht' href='./vlucht_detail?vluchtnummer=".$vlucht['vluchtnummer']."'>";
                    echo "<h3 class='label'>Bestemming:</h3>";
                    echo "<h3>".$vlucht["bestemming"]."</h3>";
                    echo "<h3 class='label'>Vertrektijd:</h3>";
                    echo "<h3>".$vlucht["vertrektijd"]."</h3>";
                    echo "<h3 class='label'>Vliegmaatschappij:</h3>";
                    echo "<h3>".$vlucht["vliegmaatschappij"]."</h3>";
                    $imagepath = "./img/". $vlucht["maatschappijcode"]. ".jpg";
                    $imagefile = file_exists($imagepath) ? $imagepath : "./img/default.jpg";
                    echo "<img alt='". $vlucht['vliegmaatschappij'] . "' src='" . $imagefile . "'>";
                    echo "</a>";
                }
            ?>
        </div>
    </div>
    <?php
        echo file_get_contents("./components/footer.html");
    ?>
</body>

</html>