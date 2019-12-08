<?php
//session_start();
include('snippets/mysqlconnect.php');

require "vendor/autoload.php";
require_once "exeptionHandlingLogin.php";

/*
 *	BladeOne Viewengine aufsetzen
 */

use eftec\bladeone\BladeOne;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';
$blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);

//var_dump($_POST);

$Error = array();
$display = 0;




var_dump($_POST);

if(empty($_POST))
{

}
elseif(!empty($_POST) && empty($_POST['e_mail']))
{


        $query2 = "Select * from Benutzer B WHERE B.Nutzername = '" . $_POST['nickname'] . "'";
        //echo $query2;
        $result2 = mysqli_query($remoteConnection, $query2);
        //echo $result2;
        //var_dump($result2);
        //echo mysqli_num_rows($result2);
        if (mysqli_num_rows($result2) > 0) {
            $Error[] = "Nickname schon vorhadnen";
            //$_POST['nickname'] = "";
            //echo $blade->run("registration", ["display_reg" => 0, "Error" => $Error]);
        } else {
            //$_GET['step'] = 2;
            //echo $blade->run("registration", ["display_reg" => 1, "Error" => $Error]);
        }
        if (strlen(strlen($_POST['passwort']) < 10)) {
            $Error[] = "Das Passwort muss mindestens 10 Zeichen lang sein.";
            //array_push($Error,["1" => 'Das Passwort muss mindestens  Zeichen lang sein.']);
        }
        //$int = mysqli_affected_rows($remoteConnection);
        if($_POST['passwort'] != $_POST['passwort_verify'])
        {
            $Error[] = "Passwort sind ist nicht gleich";
        }
        if(empty($Error))
        {
            $display = 1;
        }

}
else
{
            echo "test  ";

            $rolle = $_POST['role'];


            mysqli_begin_transaction($remoteConnection, MYSQLI_TRANS_START_READ_WRITE);

            if(insertUser($remoteConnection)) {

                    if ($rolle == 'Gast') {
                    insert_gast($remoteConnection);
                    echo "gast";
                    mysqli_commit($remoteConnection);
                    } elseif ($rolle == 'Student') {
                    insert_student($remoteConnection);
                    mysqli_commit($remoteConnection);
                    } elseif ($rolle == 'Mitarbeiter') {
                    insertMitarbeiter($remoteConnection);
                    mysqli_commit($remoteConnection);
                    }

            }
            else{
                    mysqli_rollback($remoteConnection);
            }

            //var_dump($Error);

            /*
                echo "<div class='container';

                if ($int == 1) {
                    echo '<div class="row"><h1>Ihre Registrierung hat geklappt!</h1></div>';
                    echo $blade->run("registration", ["display_reg" => 3]);
                } elseif ($int == -1) {
                    echo '<div class="row"><h1>Ihre Registrierung hat leider nicht geklappt!</h1></div>';
                    echo $blade->run("registration", ["display_reg" => 0]);
                }
            */
            //echo $blade->run("registration", ["display_reg" => 0, "Error" => $Error]);

}

var_dump($Error);


function insertUser($remoteConnection){
    $E_Mail = $_POST['e_mail'];
    $Bild = '';
    $Nutzername = $_POST['nickname'];
    $Anlege_Datum = 0;
    $Aktiv = false;
    $Vorname = $_POST['vorname'];
    $Nachname = $_POST['nachname'];
    $Geburtsdatum = $_POST['geburtsdatum'];
    $Letzter_Login = 0;
    $Hash = password_hash($_POST['passwort'], PASSWORD_DEFAULT);

    $query_user = "INSERT INTO Benutzer(`E-Mail`, Bild, Nutzername, `Anlege Datum`, Aktiv, Vorname, Nachname, Geburtsdatum, `Letzter Login`, Hash) VALUES ('$E_Mail', 0, '$Nutzername', CURRENT_DATE, 0, '$Vorname', '$Nachname', '$Geburtsdatum', NOW(), '$Hash');";
    $result_user = mysqli_query($remoteConnection, $query_user);

    echo $query_user;


    if (mysqli_errno($remoteConnection) == 1062) {
        $GLOBALS['Error'][] = "E-Mail Adresse ist bereits vergeben.";
        //$_SESSION['Display'] = 1;
        //array_push($Error,["0" => 'E-Mail Adresse oder Benutzername ist bereits vergeben.']);

    }
    //Abfrage nach Passwort Fehlern



    //echo $query_user;
    return true;
    header("Refresh:0");
}


function insertMitarbeiter($remoteConnection){

    $query_mitarbeiter = "INSERT INTO Mitarbeiter (userid, Buero, Telefon) VALUES (LAST_INSERT_ID(), '1234', 1234)";
    $result_mitarbeiter = mysqli_query($remoteConnection, $query_mitarbeiter);
}

function insert_student($remoteConnection){
    $query_student = "INSERT INTO Studenten (userid, Studiengang, Matrikelnummer) VALUES (LAST_INSERT_ID(),'$Studiengang','$Matrikel')";
    $result_student = mysqli_query($remoteConnection, $query_student);
}

function instert_fh_angehoerige($remoteConnection){

    $query_fh ="INSERT INTO `FH Angehoerige` (userid,  fachbereich_id) VALUES (LAST_INSERT_ID(), 1)";
    $query_fhzufb = "INSERT INTO `FbGehoertZuFhAngehoerige` (ID, Nummer) VALUES (LAST_INSERT_ID(), '$FbId')";
    $result_fh = mysqli_query($remoteConnection, $query_fh);
    $result_fhzufb = mysqli_query($remoteConnection, $query_fhzufb);
}

function insert_gast($remoteConnection){
    $grund = $_POST['gast-grund'];
    $query_gast ="INSERT INTO Gaeste (Nummer, Grund) VALUES (LAST_INSERT_ID(),'$grund')";
    $result_gast = mysqli_query($remoteConnection, $query_gast);
    echo $query_gast;
}

echo $blade->run("registration", ["display_reg" => $display, "Error" => $Error]);


mysqli_close($remoteConnection);