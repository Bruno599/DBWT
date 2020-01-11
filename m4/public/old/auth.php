<?php

//print_r($_POST);
/*echo '<form  class="h-100" method="post" action="'.$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'].'">
                       <fieldset class=" border border-dark h-100 w-100">
                            <legend class="h5 ml-3 w-auto p-2">Login</legend>';
if(isset($_SESSION['aktive']))
{echo '<div class="text-center m-2">
                                <input type="hidden" value="true" name="logout" >
                                <button class="btn-link btn" type="submit"> Abmelden </button>
                            </div>';
}
else
{
    echo '<div class="text-center m-2">
                                <input class="m-2" type="text" placeholder="Benutzer" name="benutzer"><br>
                                <input class="m-2" type="password" placeholder="Passwort" name="passwort">
                                <button class="btn-link btn" type="submit"> Anmelden </button>
                            </div>';
}
echo '                        </fieldset>
                    </form>';
*/
if(!isset($_POST['benutzer']) && !isset($_POST['passwort']) && !isset($_SESSION['aktive']))
{
    //echo 'test1';
   //echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
   echo '<form  class="h-100" method="post" action="'.$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'].'">
                       <fieldset class=" border border-dark h-100 w-100">
                            <legend class="h5 ml-3 w-auto p-2">Login</legend>
                            <div class="text-center m-2">
                                <input class="m-2" type="text" placeholder="Benutzer" name="benutzer"><br>
                                <input class="m-2" type="password" placeholder="Passwort" name="passwort">
                                <button class="btn-link btn" type="submit"> Anmelden </button>
                            </div>     
                    </fieldset>
        </form>';
}elseif(isset($_SESSION['aktive'])){

    if (isset($_POST['logout'])) {
            session_destroy();
            echo 'Sie wurden erfolgreich ausgeloggt';
        header("Refresh:0");
        }else {
        echo '<form  class="h-100" method="post" action="' . $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] . '">
                       <fieldset class=" border border-dark h-100 w-100">
                            <legend class="h5 ml-3 w-auto p-2">Login</legend>
                            <div class="text-center m-2">
                                <input type="hidden" value="true" name="logout" >
                                <button class="btn-link btn" type="submit"> Abmelden </button>
                            </div>
                            </fieldset>
                    </form>';

    }
}
else {
    if(isset($_POST['benutzer']) && isset($_POST['passwort'])) {
        if ($_POST['benutzer'] != "" && $_POST['passwort'] != "") {
            //echo 'test2';
            /*echo '<form  class="h-100" method="post" action="'.$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'].'">
                       <fieldset class=" border border-dark h-100 w-100">
                            <legend class="h5 ml-3 w-auto p-2">Login</legend>
                            <div class="text-center m-2">
                                <input class="m-2" type="text" placeholder="Benutzer" name="benutzer"><br>
                                <input class="m-2" type="password" placeholder="Passwort" name="passwort">
                                <button class="btn-link btn" type="submit"> Anmelden </button>
                            </div>
                            </fieldset>
                    </form>';*/
            $benutzer = $_POST['benutzer'];
            $passwort = $_POST['passwort'];


            $query4 = "select B.Nummer, B.Hash, B.Vorname, B.Nachname, NR.Rolle from Benutzer B, Nutzerrollen NR WHERE B.Nutzername = '$benutzer' AND B.Nummer = NR.Nummer";
            $result4 = mysqli_query($remoteConnection, $query4);
            if (mysqli_num_rows($result4)) {
                $row4 = mysqli_fetch_array($result4);
                if (password_verify($passwort, $row4['Hash'])) {
                    $_SESSION['nutzername'] = $benutzer;
                    $_SESSION['passwort'] = $row4['Hash'];
                    $_SESSION['vorname'] = $row4['Vorname'];
                    $_SESSION['nachname'] = $row4['Nachname'];
                    $_SESSION['role'] = $row4['Rolle'];
                    $_SESSION['aktive'] = true;

                    $query1 = "Update Benutzer B set `Letzter Login` = CURRENT_DATE WHERE B.Nutzername = '$benutzer')";
                    header("Refresh:0");
                }
                else{
                    echo '<form  class="h-100" method="post" action="'.$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'].'">
                       <fieldset class=" border border-dark h-100 w-100">
                            <legend class="h5 ml-3 w-auto p-2">Login</legend>
                            <a>Login incorrect</a>
                            <div class="text-center m-2">
                                <input class="m-2" type="text" placeholder="Benutzer" name="benutzer"><br>
                                <input class="m-2" type="password" placeholder="Passwort" name="passwort">
                                <button class="btn-link btn" type="submit"> Anmelden </button>
                            </div>
                            </fieldset>
                    </form>';
                }
            } else {
                echo '<form  class="h-100" method="post" action="'.$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'].'">
                       <fieldset class=" border border-dark h-100 w-100">
                            <legend class="h5 ml-3 w-auto p-2">Login</legend>
                            <a>Login incorrect</a>
                            <div class="text-center m-2">
                                <input class="m-2" type="text" placeholder="Benutzer" name="benutzer"><br>
                                <input class="m-2" type="password" placeholder="Passwort" name="passwort">
                                <button class="btn-link btn" type="submit"> Anmelden </button>
                            </div>
                            </fieldset>
                    </form>';
            };
        } elseif ($_POST['benutzer'] == "" && $_POST['passwort'] != "") {
            echo '<form  class="h-100" method="post" action="'.$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'].'">
                       <fieldset class=" border border-dark h-100 w-100">
                            <legend class="h5 ml-3 w-auto p-2">Login</legend>
                            <p>Benutzer ist nicht ausgefüllt, anmeldung nicht möglich</p>
                            <div class="text-center m-2">
                                <input class="m-2" type="text" placeholder="Benutzer" name="benutzer"><br>
                                <input class="m-2" type="password" placeholder="Passwort" name="passwort">
                                <button class="btn-link btn" type="submit"> Anmelden </button>
                            </div>
                            </fieldset>
                    </form>';
        } elseif ($_POST['benutzer'] != "" && $_POST['passwort'] == "") {
            echo '<form  class="h-100" method="post" action="'.$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'].'">
                       <fieldset class=" border border-dark h-100 w-100">
                            <legend class="h5 ml-3 w-auto p-2">Login</legend>
                            <p>Passwort ist nicht ausgefüllt, anmeldung nicht möglich</p>
                            <div class="text-center m-2">
                                <input class="m-2" type="text" placeholder="Benutzer" name="benutzer"><br>
                                <input class="m-2" type="password" placeholder="Passwort" name="passwort">
                                <button class="btn-link btn" type="submit"> Anmelden </button>
                            </div>
                            </fieldset>
                    </form>';}
         elseif ($_POST['benutzer'] == "" && $_POST['passwort'] == "") {
            echo '<form  class="h-100" method="post" action="'.$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'].'">
                       <fieldset class=" border border-dark h-100 w-100">
                            <legend class="h5 ml-3 w-auto p-2">Login</legend>
                            <p>Benutzer und Passwort sind nicht ausgefüllt, anmeldung nicht möglich</p>
                            <div class="text-center m-2">
                                <input class="m-2" type="text" placeholder="Benutzer" name="benutzer"><br>
                                <input class="m-2" type="password" placeholder="Passwort" name="passwort">
                                <button class="btn-link btn" type="submit"> Anmelden </button>
                            </div>
                            </fieldset>
                    </form>';
        } else {
            echo 'false';
        }
    }
}



echo '</body>
</html>';