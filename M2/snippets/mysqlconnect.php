<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__,'/../connection.env');
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS','DB_PORT']);

$remoteConnection = mysqli_connect(getenv('DB_HOST'),getenv('DB_USER'),getenv('DB_PASS'),getenv('DB_NAME'));

if (mysqli_connect_errno()) {
    printf("Konnte nicht zur entfernten Datenbank verbinden: %s\n", mysqli_connect_error());
    exit();
}
//if ($result = mysqli_query($remoteConnection, $query)) {
//    while ($row = mysqli_fetch_assoc($result)) {
// $row['ID'] und $row['Name'] stehen aus der Query zur Verfügung
//        echo '<li id="id-'.$row['ID'].'">'.$row['Name'].'</li>';
//    }
//}



// mysqli_close($remoteConnection); // daran denken, die Verbindung wieder zu schließen wenn sie nicht mehr benötigt ist.
