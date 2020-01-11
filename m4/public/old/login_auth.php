<?php
/*
require "vendor/autoload.php";


//BladeOne Viewengine aufsetzen


use eftec\bladeone\BladeOne;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';
$blade2 = new BladeOne($views,$cache,BladeOne::MODE_AUTO);



 * Daten vorbereiten (das sind später die Models),
 * d.h. die Queries an die DB senden und in Arrays
 * oder Objekten speichern, damit sie an die Views
 * übergeben werden können

include('snippets/mysqlconnect.php');
*/

$display = 0;

//var_dump($_POST);
//var_dump($_SESSION);

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

if(!isset($_POST['benutzer']) && !isset($_POST['passwort']) && !isset($_SESSION['aktive']))
{
    //echo 'test1';
    //echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
   $display = 0;
}elseif(isset($_SESSION['aktive'])){

    if (isset($_POST['logout']) && $_POST['logout'] == true){
        unset($_SESSION);
        session_destroy();
        //echo 'Sie wurden erfolgreich ausgeloggt';
        //header("Refresh:0");
        unset($_POST);
        $display = 0;
    }else {
        //anzeige 3 abmelden
        $display = 1;
    }
}
else {
    if(isset($_POST['benutzer']) && isset($_POST['passwort'])) {
        if ($_POST['benutzer'] != "" && $_POST['passwort'] != "") {

            $benutzer = $_POST['benutzer'];
            $passwort = $_POST['passwort'];

            $query4 = "select B.Nummer, B.Hash, B.Vorname, B.Nachname, NR.Rolle from Benutzer B, Nutzerrollen NR WHERE B.Nutzername = '$benutzer' AND B.Nummer = NR.Nummer";
            $result4 = mysqli_query($remoteConnection, $query4);
            if (mysqli_num_rows($result4)) {
                $row4 = mysqli_fetch_array($result4);
                if (password_verify($passwort, $row4['Hash'])) {
                    $_SESSION['nutzername'] = $benutzer;
                    $_SESSION['passwort'] = $row4['Hash'];
                    $_SESSION['user'] = $row4['Vorname'];
                    $_SESSION['nachname'] = $row4['Nachname'];
                    $_SESSION['role'] = $row4['Rolle'];
                    $_SESSION['aktive'] = true;
                    $_SESSION['id'] = $row4['Nummer'];

                    $query_timestamp = "Update Benutzer B set `Letzter Login` = current_timestamp WHERE B.Nutzername = '$benutzer'";
                    //header("Refresh:0");
                    mysqli_query($remoteConnection, $query_timestamp);
                    $display = 1;
                } else {

                    $display = -1;

                }
            } else {

                $display = -1;
                // <a>Login incorrect</a>

            };
        }else{
            $display = -1;
        }
    }else{
        $display = 0;
    }
}

