<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produkt;
use Illuminate\Support\Facades\DB;
require_once "../vendor/autoload.php";

class mahlzeitenController extends Controller
{
    public function show()
    {
        session_start();

        //@section('navbaroben');


        $query = "SELECT M.ID, M.Name, M.`Verfügbar`, M.inKategorie, (COUNT(Z.ID) - SUM(Z.Vegan)) AS VeganIndex, 
        (COUNT(Z.ID) - SUM(Z.Vegetarisch)) AS VegetarischIndex, B.`Alt-Text`, B.`Binärdaten` 
        FROM Mahlzeiten M 
        LEFT JOIN MahlzeitenHabenBilder MHB ON M.ID = MHB.ID_M 
        LEFT JOIN Bilder B ON MHB.ID_B = B.ID 
        LEFT JOIN MahlzeitenEnthaltenZutaten MEZ ON M.ID = MEZ.ID_M 
        LEFT JOIN Zutaten Z on MEZ.ID_Z = Z.ID 
        WHERE B.`Alt-Text` != '0'";

        if (isset($_POST['avail'])) {
            $query .= ' AND (M.`Verfügbar` = 1)';
        }

        if (isset($_POST['kategorien']) && $_POST['kategorien'] != '-1') {
            $query .= ' AND (M.inKategorie = \'' . $_POST['kategorien'] . '\')';
        }
        $query .= ' GROUP BY M.ID';

        if (isset($_POST['vegetarisch']) && !isset($_POST['vegan'])) {
            $query .= ' HAVING (VegetarischIndex = 0)';
        } else if (isset($_POST['vegan']) && !isset($_POST['vegetarisch'])) {
            $query .= ' HAVING (VeganIndex = 0)';
        } else if (isset($_POST['vegetarisch']) && isset($_POST['vegan'])) {
            $query .= ' HAVING (VegetarischIndex = 0) AND (VeganIndex = 0)';
        }
        $query .= ' ORDER BY M.inKategorie, M.Name';

        if (isset($_GET['limit'])) {
            $query .= ' LIMIT ' . $_GET['limit'];
        }
//echo $_GET['limit'];
//echo $query;

        $result = DB::select($query);
        //$result = mysqli_query($remoteConnection, $query);
        //var_dump($result);

//$query2 ="select Kategorien.ID, Kategorien.Bezeichnung, Kategorien.hatKategorie FROM Kategorien ORDER BY Kategorien.hatKategorie ASC";
//$query2 = "select Kategorien.ID, Kategorien.Bezeichnung, Kategorien.hatKategorie From Kategorien where Kategorien.hatKategorie is null OR Kategorien.ID in (SELECT inKategorie FROM Mahlzeiten Where Verfügbar = true) ORDER BY Kategorien.hatKategorie ASC";
        $query2 = "select Kategorien.ID, Kategorien.Bezeichnung, Kategorien.hatKategorie From Kategorien where Kategorien.hatKategorie is null OR Kategorien.ID in (SELECT inKategorie FROM Mahlzeiten) ORDER BY Kategorien.hatKategorie ASC";

        $result2 = DB::select($query2);
        //$result2 = mysqli_query($remoteConnection, $query2);

        $array = array();
        $array2 = 'Alle zeigen';
        //var_dump($result2);
        $count = 0;
/*
         do{
            array_push($array, array("ID" => $result2[$count]->ID, "Bezeichnung" => $result2[$count]->Bezeichnung, "hatKategorie" => $result2[$count]->hatKategorie));

            if (isset($_POST['kategorien']) && $result2[$count]->ID == $_POST['kategorien']) {
                $array2 = $result2[$count]->Bezeichnung;
            }
            $count++;
        }while (next($result2));

         echo 'test';
         var_dump($array);
*/
        $data = $result;
/*

        while ($row = mysqli_fetch_assoc($result)) {
            array_push($data, array("ID" => $row['ID'], "Name" => $row['Name'], "Verfügbar" => $row['Verfügbar'], "Binärdaten" => base64_encode($row['Binärdaten'])));
        }
        /*foreach ($array as $arra)
        {
            echo $arra['Bezeichnung'];
            echo $arra['hatKategorie'];
        }
        *
        $variables = array();
        */
//echo $_POST['avail'];
//echo $_POST['vegetarisch'];
//echo $_POST['vegan'];

        echo '</select>';
        if (isset($_POST["avail"]) && $_POST["avail"] == '1') {
            $variables['avail'] = true;
        } else {
            $variables['avail'] = false;
        }

        if (isset($_POST['vegetarisch']) && $_POST["vegetarisch"] == '1') {
            $variables['vegetarisch'] = true;
        } else {
            $variables['vegetarisch'] = false;
        }

        if (isset($_POST['vegan']) && $_POST["vegan"] == '1') {
            $variables['vegan'] = true;
        } else {
            $variables['vegan'] = false;
        }

        if (isset($_POST['kategorien'])) {
            $variables['kategorien'] = $_POST['kategorien'];
        } else {
            $variables['kategorien'] = '-1';
        }


        //echo $blade->run("produkte", array("array" => $data, "variables" => $variables, "kat" => $array, "array2" => $array2));
        return view('pages.produkte', ["array" => $data, "variables" => $variables, "kat" => $result2, "array2" => $array2]);

        //mysqli_close($remoteConnection);

    }
}
