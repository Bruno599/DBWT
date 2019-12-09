<?php
session_start();

require "vendor/autoload.php";

use eftec\bladeone\BladeOne;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';
$blade = new BladeOne($views,$cache,BladeOne::MODE_AUTO);

/*
 * Daten vorbereiten (das sind später die Models),
 * d.h. die Queries an die DB senden und in Arrays
 * oder Objekten speichern, damit sie an die Views
 * übergeben werden können
 */

/*
$query = 'SELECT COUNT(ID) as count FROM Zutaten;';
$result = mysqli_query($remoteConnection, $query);
$count= mysqli_fetch_assoc($result);
*/

echo $blade->run("start");