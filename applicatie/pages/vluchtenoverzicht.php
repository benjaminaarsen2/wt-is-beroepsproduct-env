<?php
    session_start();
    require_once "./db/db_vlucht.php";
    $vluchten = isset($_POST["sorteer"]) ? haalAlleVluchtenBasisOp($_POST["sorteer"]) : haalAlleVluchtenBasisOp();
    // De functie returnt false als de sorteermethode anders is dan in code mogelijk, 
    // wat betekent dat er SQL-injectie plaats heeft gevonden
    if ($vluchten === false) {
        echo "<h2>Not this time, bitch</h2>";
        exit();
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
        <div class="filters">
            <h2>Fitlers</h2>
            <p>...</p>
            <p>...</p>
            <p>...</p>
            <p>...</p>

        </div>
    </div>
    <div class="hero">
        <!-- TODO: sorteer dropdown: tijd, luchthaven -->
        <form action="./vluchtenoverzicht.php" method="post" class="sortmenu">
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