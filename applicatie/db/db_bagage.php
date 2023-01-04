<?php
require_once "db_connectie.php";
$db = maakVerbinding();

function bagageToevoegen($passagiernummer, $aantalkoffers, array $gewicht) {
    global $db;
    require_once "db_passagier.php";
    $ingecheckte_koffers = aantalIngecheckteKoffers($passagiernummer);

    if (count($gewicht) !== $aantalkoffers) {
        return false;
    }
    for($k = 0; $k < $aantalkoffers; $k++) {
        $query = $db->prepare(
            "INSERT INTO BagageObject (passagiernummer, objectvolgnummer, gewicht) VALUES (:passagiernummer, :objectvolgnummer, :gewicht)"
        );
        $objectvolgnummer = $ingecheckte_koffers + $k;
        $query->bindParam(":passagiernummer", $passagiernummer);
        $query->bindParam(":objectvolgnummer", $objectvolgnummer);
        $query->bindParam(":gewicht", $gewicht[$k]);
        $query->execute();
    }
    return true;
}

?>  