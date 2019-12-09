<?php
//session_start();
include('snippets/mysqlconnect.php');

require "vendor/autoload.php";
require_once "exeptionHandlingLogin.php";

/*
 *	BladeOne Viewengine aufsetzen
 */

/*if(session_status() != PHP_SESSION_ACTIVE){
    session_start();
}
*/

use eftec\bladeone\BladeOne;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';
$blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);

//var_dump($_POST);

$Error = array();
$display = 1;
$data = array();

//var_dump($_POST);


if(!empty($_POST) && !empty($_POST['e_mail']))
{
    //echo "test  ";

    $rolle = $_POST['role'];


    mysqli_begin_transaction($remoteConnection, MYSQLI_TRANS_START_READ_WRITE);

    if(insertUser($remoteConnection)) {

        if ($rolle == 'Gast') {
            insert_gast($remoteConnection);
            echo "gast";
            mysqli_commit($remoteConnection);
        } elseif ($rolle == 'Student') {
            if(instert_fh_angehoerige($remoteConnection)){
                if(insert_student($remoteConnection)){
                    mysqli_commit($remoteConnection);
                }else
                {
                    mysqli_rollback($remoteConnection);

                    $display = 2;
                }
            }else{
                mysqli_rollback($remoteConnection);

                $display = 2;
            }


        } elseif ($rolle == 'Mitarbeiter') {
            if(instert_fh_angehoerige($remoteConnection)){
                if(insertMitarbeiter($remoteConnection)){
                    mysqli_commit($remoteConnection);
                }
                else{
                    mysqli_rollback($remoteConnection);

                    $display = 2;
                }
            }else{
                mysqli_rollback($remoteConnection);

                $display = 2;
            }


        }

        $query_nummer = "select Nummer From Benutzer Where Nutzername = '".$_POST['nickname']."'";
        $result_nummer= mysqli_query($remoteConnection, $query_nummer);
        $_POST['nummer'] = mysqli_fetch_row($result_nummer);
        $display = 3;


    }
    else{

        mysqli_rollback($remoteConnection);

        $display = 2;

    }



}

if(!empty($_POST) && empty($_POST['e_mail'])) {


    $query2 = "Select * from Benutzer B WHERE B.Nutzername = '" . $_POST['nickname'] . "'";

    $result2 = mysqli_query($remoteConnection, $query2);


    if (mysqli_num_rows($result2) > 0) {
        $Error[] = "Nickname schon vorhanden";

    }

    if (strlen(strlen($_POST['passwort']) < 10)) {
        $Error[] = "Das Passwort muss mindestens 10 Zeichen lang sein.";
        //array_push($Error,["1" => 'Das Passwort muss mindestens  Zeichen lang sein.']);
    }
    //$int = mysqli_affected_rows($remoteConnection);
    if ($_POST['passwort'] != $_POST['passwort_verify']) {
        $Error[] = "Passwort sind ist nicht gleich";
    }
    if (!isset($_POST['role'])){
        $Error[] = "Keine Rolle Ausgewählt";
    }
    if (empty($Error)) {
        $display = 2;


        //if($rolle != 'Gast'){
        $_query_Fb = "select Fb.ID , Fb.Name From Fachbereich Fb";
        $_result_Fb = mysqli_query($remoteConnection,$_query_Fb);

        //}
        while($row_fb = mysqli_fetch_assoc($_result_Fb)) {
            $data[] = $row_fb;
        }
        var_dump($data);
    }


}
//var_dump($Error);


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

    //echo $query_user;


    if (mysqli_errno($remoteConnection) == 1062) {
        $GLOBALS['Error'][] = "E-Mail Adresse ist bereits vergeben.";
        //$_SESSION['Display'] = 1;
        //array_push($Error,["0" => 'E-Mail Adresse oder Benutzername ist bereits vergeben.']);
    return false;
    }
    //Abfrage nach Passwort Fehlern



    //echo $query_user;
    return true;
    //header("Refresh:0");
}


function insertMitarbeiter($remoteConnection){

    $query_mitarbeiter = "INSERT INTO Mitarbeiter (Nummer, Büro, Telefon) VALUES (LAST_INSERT_ID(), '".$_POST['buero']."', ".$_POST['telnummer'].")";
    $result_mitarbeiter = mysqli_query($remoteConnection, $query_mitarbeiter);
    if(mysqli_error($remoteConnection)){
        $GLOBALS['Error'][] = "Büro oder Telefonnummer falsch";
        return false;
    }
    //echo $query_mitarbeiter;
    return true;
}

function insert_student($remoteConnection){
    $query_student = "INSERT INTO Studenten (userid, Studiengang, Matrikelnummer) VALUES (LAST_INSERT_ID(),'$Studiengang','$Matrikel')";
    $result_student = mysqli_query($remoteConnection, $query_student);
}

function instert_fh_angehoerige($remoteConnection){

    $query_fh ="INSERT INTO `FH Angehoerige` (Nummer) VALUES (LAST_INSERT_ID())";
    $result_fh = mysqli_query($remoteConnection, $query_fh);
    if(mysqli_error($remoteConnection)){
        $GLOBALS['Error'][] = "Fehler beim einfügen in FH-Angehörige";
        return false;
    }
    $query_fhzufb = "INSERT INTO `FbGehoertZuFhAngehoerige` (ID, Nummer) VALUES ( ".$_POST['fachbereich'].",LAST_INSERT_ID())";
    $result_fhzufb = mysqli_query($remoteConnection, $query_fhzufb);

    if(mysqli_error($remoteConnection)){
        $GLOBALS['Error'][] = "Fehler beim Fachbereich";
        return false;
    }

    //echo $query_fh;
    //echo $query_fhzufb;
    return true;
}

function insert_gast($remoteConnection){
    $grund = $_POST['gast-grund'];
    $query_gast ="INSERT INTO Gaeste (Nummer, Grund) VALUES (LAST_INSERT_ID(),'$grund')";
    $result_gast = mysqli_query($remoteConnection, $query_gast);
    //echo $query_gast;
}

echo $blade->run("registration", ["display_reg" => $display, "Error" => $Error, "data_fb" => $data]);


mysqli_close($remoteConnection);