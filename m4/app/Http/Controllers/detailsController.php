<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produkt;
use Illuminate\Support\Facades\DB;
require_once "../vendor/autoload.php";

class detailsController extends Controller
{

    public function login($benutzer, $passwort, $logout = false){
        $display = 0;

    //var_dump($_POST);
    //var_dump($_SESSION);

        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }

        if(empty($benutzer) && empty($passwort) && !isset($_SESSION['aktive']))
        {
            //echo 'test1';
            //echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
            $display = 0;
        }elseif(isset($_SESSION['aktive'])){

            if (!empty($logout) && $_POST['logout'] == true){
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
            if(!empty($benutzer) && !empty($passwort)) {
                if ($benutzer != "" && $passwort!= "") {

                    //$benutzer = $_POST['benutzer'];
                    //$passwort = $_POST['passwort'];

                    $query4 = "select B.Nummer, B.Hash, B.Vorname, B.Nachname, NR.Rolle from Benutzer B, Nutzerrollen NR WHERE B.Nutzername = '$benutzer' AND B.Nummer = NR.Nummer";
                    //$result4 = mysqli_query($remoteConnection, $query4);
                    $result4 = DB::select($query4);
                    //var_dump($result4);

                    if (!empty($result4)) {
                        //$row4 = mysqli_fetch_array($result4);
                        if (password_verify($passwort, $result4[0]->Hash)) {
                            $_SESSION['nutzername'] = $benutzer;
                            $_SESSION['passwort'] = $result4[0]->Hash;
                            $_SESSION['user'] = $result4[0]->Vorname;
                            $_SESSION['nachname'] = $result4[0]->Nachname;
                            $_SESSION['role'] = $result4[0]->Rolle;
                            $_SESSION['aktive'] = true;
                            $_SESSION['benutzerID'] = $result4[0]->Nummer;

                            $query_timestamp = "Update Benutzer B set `Letzter Login` = current_timestamp WHERE B.Nutzername = '$benutzer'";
                            //header("Refresh:0");
                            //mysqli_query($remoteConnection, $query_timestamp);
                            DB::update($query_timestamp);
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

        return $display;
    }



    public function show($display = 0){
        //session_destroy();

        if(!empty($_POST['bewertung'])){
            echo 'test';
            bewertungsController::insert($_POST['mahlzeitID'], $_POST['benutzerID'], $_POST['bewertung'], $_POST['bemerkung']);
        }

        if(!empty($_POST['benutzer'])){

            $display =  $this->login($_POST['benutzer'], $_POST['passwort']);
            echo $display.'!!!!!!!!!!!!!!!!!';
        }else{
            if(isset($_POST['logout'])){
                $logout = $_POST['logout'];
            }else{
                $logout = false;
            }
            $display =  $this->login("", "", $logout);
        }





        $value = $_GET["id"];
        $mahlzeit[4] = 0;
        //echo $value;
        $query="select Mahlzeiten.Name, Mahlzeiten.Beschreibung, P.Gastpreis, P.Studentpreis, P.`MA-Preis`, B.Binärdaten FROM Mahlzeiten
    LEFT JOIN Preise P on Mahlzeiten.ID = P.MahlzeitID
    LEFT JOIN MahlzeitenHabenBilder MHB on Mahlzeiten.ID = MHB.ID_M
    LEFT JOIN Bilder B on MHB.ID_B = B.ID
    WHERE Mahlzeiten.ID = '$value' GROUP BY Mahlzeiten.Name";

        $resultdb = DB::select($query);
        //$result = mysqli_query($remoteConnection, $query);
        //var_dump($result);
        $result =  $resultdb[0];
        if(!empty($result))
        {
            $mapreis='MA-Preis';
            $refresh = false;
            $mahlzeit['Name'] = $result->Name;
            $mahlzeit['Beschreibung'] = $result->Beschreibung;
            if(isset($_SESSION['aktive']) && $_SESSION['aktive'] == true)
            {if($_SESSION['role'] == 'Gast'){
                $mahlzeit['Preis'] =  $result->Gastpreis;
            }elseif ($_SESSION['role'] == 'Student'){
                $mahlzeit['Preis'] = $result->Studentpreis;
            }elseif ($_SESSION['role'] == 'Mitarbeiter') {
                $mahlzeit['Preis'] = $result->$mapreis;
            }
            }else
            {
                $mahlzeit['Preis'] = $result->Gastpreis ;
            }
            $mahlzeit['Binärdaten'] = base64_encode($result->Binärdaten);

        }else{
            $refresh = true;
        }
        //session_destroy();
        //var_dump($_SESSION);
        //var_dump($mahlzeit);
        $query2 = "select Z.Name FROM Zutaten Z left join MahlzeitenEnthaltenZutaten MEZ on Z.ID = MEZ.ID_Z left join Mahlzeiten M on MEZ.ID_M = M.ID WHERE M.ID = '".$_GET['id']."'";
        $result2 = DB::select($query2);
        //$result2 = mysqli_query($remoteConnection,$query2);
        //$row2 = mysqli_fetch_all($result2,MYSQLI_ASSOC);

        $query3 = "SELECT  K.Bemerkung, K.Bewertung, K.Zeitpunkt, B.Nutzername FROM Kommentare K
                    LEFT JOIN Studenten S on K.GeschriebenVon = S.Nummer
                    LEFT JOIN `FH Angehoerige` `F A` on S.Nummer = `F A`.Nummer
                    LEFT JOIN Benutzer B on `F A`.Nummer = B.Nummer
                    WHERE K.GehörtZu = $value ORDER BY Zeitpunkt DESC";
        $result3 = DB::select($query3);
        $size = sizeof($result3);
        $count = 0;
        $sum = 0;
        $arrayresult = array();
        do{
            if($count < 5) {
                array_push($arrayresult, $result3[$count]);
            }
            $sum = $sum + $result3[$count]->Bewertung;
            $count++;
        }while(next($result3));
        $durchschnitt = ($sum/$size);
        //var_dump($result3);
        //echo $sum;


//echo "<img src=\"data:image/jpeg;base64, ".base64_encode($row['Binärdaten'])."\">";

//include ('snippets/navbaroben.php'); //include header



        //echo $blade->run("details",array("refresh"=>$refresh, "mahlzeit" => $mahlzeit, "display2"=> $display, "zutaten" => $row2));
        return view('pages.details', ["refresh"=>$refresh, "mahlzeit" => $mahlzeit, "zutaten" => $result2, "display2"=> $display, "bewertung" => $arrayresult, "size" => $size, "durchschnitt" => $durchschnitt]);

    }
}
