<?php
require_once "controller/zutatenController.php";

$controller = new Emensa\Controller\ZutatenController();
$controller->zutaten();

/*
 *	BladeOne Viewengine aufsetzen


use eftec\bladeone\BladeOne;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';
$blade = new BladeOne($views,$cache,BladeOne::MODE_AUTO);


 * Daten vorbereiten (das sind später die Models),
 * d.h. die Queries an die DB senden und in Arrays
 * oder Objekten speichern, damit sie an die Views
 * übergeben werden können



$query = 'SELECT COUNT(ID) as count FROM Zutaten;';
$result = mysqli_query($remoteConnection, $query);
$count= mysqli_fetch_assoc($result);


include('snippets/mysqlconnect.php');

$query2 = 'SELECT COUNT(ID) as anzahl FROM Zutaten;';
$result2 = mysqli_query($remoteConnection, $query2);
$count = mysqli_fetch_assoc($result2);

//echo $count;

$zutaten = array();

$query = "SELECT Name,Bio,Vegetarisch,Vegan,Glutenfrei FROM Zutaten ORDER BY bio DESC ,Name ASC";
$result = mysqli_query($remoteConnection, $query);
while($row = mysqli_fetch_assoc($result)){
    //$zutaten[] = $row;
    array_push($zutaten, array("Name" => $row['Name'], "Bio" => $row['Bio'],
        "Vegetarisch" => $row['Vegetarisch'], "Vegan" => $row['Vegan'], "Glutenfrei" => $row['Glutenfrei']));
}

foreach ($array as $arra)
{
    echo $arra['Name'];
    echo $arra['Bio'];
}

$title = "Zutaten";

//include ('snippets/navbaroben.php');

echo $blade->run("zutaten",array("zutaten"=>$zutaten, "anzahl" => "$count[anzahl]"));

//include ('snippets/navbarunten.php');

mysqli_close($remoteConnection);

*/