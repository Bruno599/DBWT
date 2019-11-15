<?php

$remoteConnection = mysqli_connect('149.201.88.110', 's_ds1818s', '!J242THEI7', 'db3188412');

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
