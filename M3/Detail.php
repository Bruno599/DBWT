<?php
//session_start();

require "vendor/autoload.php";

/*
 *	BladeOne Viewengine aufsetzen
 */

use eftec\bladeone\BladeOne;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';
$blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);

/*
 * Daten vorbereiten (das sind später die Models),
 * d.h. die Queries an die DB senden und in Arrays
 * oder Objekten speichern, damit sie an die Views
 * übergeben werden können
 */

    include ('snippets/mysqlconnect.php');
    include ('login.php');
    $value = $_GET["id"];
    $mahlzeit[4] = 0;
    //echo $value;
    $query="select Mahlzeiten.Name, Mahlzeiten.Beschreibung, P.Gastpreis, P.Studentpreis, P.`MA-Preis`, B.Binärdaten FROM Mahlzeiten
    LEFT JOIN Preise P on Mahlzeiten.ID = P.MahlzeitID
    LEFT JOIN MahlzeitenHabenBilder MHB on Mahlzeiten.ID = MHB.ID_M
    LEFT JOIN Bilder B on MHB.ID_B = B.ID
    WHERE Mahlzeiten.ID = '$value'";
    $result = mysqli_query($remoteConnection, $query);
    if($row = mysqli_fetch_assoc($result))
    {
        $refresh = false;
        $mahlzeit['Name'] = $row['Name'];
        $mahlzeit['Beschreibung'] = $row['Beschreibung'];
        if(isset($_SESSION['aktive']) && $_SESSION['aktive'] == true)
        {if($_SESSION['role'] == 'Gast'){
            $mahlzeit['Preis'] =  $row['Gastpreis'];
        }elseif ($_SESSION['role'] == 'Student'){
            $mahlzeit['Preis'] = $row['Studentpreis'];
        }elseif ($_SESSION['role'] == 'Mitarbeiter') {
            $mahlzeit['Preis'] = $row['MA-Preis'];
            }
        }else
        {
            $mahlzeit['Preis'] = $row['Gastpreis'] ;
        }
        $mahlzeit['Binärdaten'] = base64_encode($row['Binärdaten']);

    }else{
        $refresh = true;
    }

//echo "<img src=\"data:image/jpeg;base64, ".base64_encode($row['Binärdaten'])."\">";

//include ('snippets/navbaroben.php'); //include header



echo $blade->run("details",array("refresh"=>$refresh, "mahlzeit" => $mahlzeit, "display2"=> $display));


   // include ('auth.php');


mysqli_close($remoteConnection);
//include ('snippets/navbarunten.php');


