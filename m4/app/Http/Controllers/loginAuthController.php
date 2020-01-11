<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produkt;
use Illuminate\Support\Facades\DB;

class loginAuthController extends Controller
{
    public function show(){
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
                    //$result4 = mysqli_query($remoteConnection, $query4);
                    $result4 = DB::select($query4);

                    if (!empty($result4)) {
                        //$row4 = mysqli_fetch_array($result4);
                        if (password_verify($passwort, $result4->Hash)) {
                            $_SESSION['nutzername'] = $benutzer;
                            $_SESSION['passwort'] = $result4->Hash];
                            $_SESSION['user'] = $result4->Vorname;
                            $_SESSION['nachname'] = $result4->Nachname;
                            $_SESSION['role'] = $result4->Rolle;
                            $_SESSION['aktive'] = true;

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
    }
}
