<?php
session_start();
require "vendor/autoload.php";
use eftec\bladeone\BladeOne;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';
$blade = new BladeOne($views,$cache,BladeOne::MODE_AUTO);


//@section('navbaroben');
include ('snippets/mysqlconnect.php');

/* #00b5ad  Farbcode der Links


if(isset($_POST["avail"]))
{
    $limit1 = $_POST["limit"];
}else{
    $limit1 = 4;
}
;


if(isset($_POST["avail"])) {
    if($limit1 > 0) {
        $query="select ID, Name, Verfügbar FROM Mahlzeiten WHERE Verfügbar = true LIMIT $limit1";
    }
    else {
            $query="select ID, Name, Verfügbar FROM Mahlzeiten WHERE Verfügbar = true";
        }
}
else {
    if($limit1 > 0) {
        $query="select ID, Name, Verfügbar FROM Mahlzeiten LIMIT $limit1";
    }
    else {
        $query="select ID, Name, Verfügbar FROM Mahlzeiten";
    }
}

$avail = "Verfügbar = true";
*/
/*
$query_begin = "select M.ID, M.Name, M.Verfügbar, M.inKategorie, B.Binärdaten FROM Mahlzeiten M ";
$bilder1 = "LEFT JOIN MahlzeitenHabenBilder MHB on M.ID = MHB.ID_M LEFT JOIN Bilder B on MHB.ID_B = B.ID ";

if(isset($_GET['limit']))
{
    $limit1 = "ORDER BY M.Name ASC LIMIT ".$_GET['limit'];
}
else
{
    $limit1 = "";
}

if (isset($_POST['kategorien']) || isset($_POST['vegan']) || isset($_POST['vegetraisch']) || isset($_POST['gluten']) || isset($_POST['avail'])){
    $where = "WHERE M.ID != 0 ";
}else{
    $where = "";
}

if (isset($_POST['avail'])) {
    $avail1 = "AND M.Verfügbar = true ";
}else{
    $avail1 = "";
}

if(isset($_POST['kategorien']) && $_POST['kategorien'] != 'Alle zeigen')
{
    $kategorie1 = "LEFT JOIN Kategorien K ON K.ID = M.inKategorie ";
    $kategorie2 = " AND K.ID = (Select ID From Kategorien Where Kategorien.Bezeichnung = '".$_POST['kategorien']."') ";
}
else
{
    $kategorie1 = "";
    $kategorie2 = "";
}

if(isset($_POST['vegan']) || isset($_POST['vegetraisch']) || isset($_POST['gluten'])){
    $Zutaten1 = "LEFT JOIN MahlzeitenEnthaltenZutaten MEZ on M.ID = MEZ.ID_M LEFT JOIN Zutaten Z on MEZ.ID_Z = Z.ID ";
}
else{
    $Zutaten1 = "";
}

if (isset($_POST['vegan'])) {
    $Zutaten2 = "AND Z.Vegan = 'true' ";
}
else {
    $Zutaten2 = "";
}

if (isset($_POST['vegetarisch'])) {
    $Zutaten3 = " AND Z.Vegetarisch = 'true' ";
}
else {
    $Zutaten3 = "";
}

if(isset($_POST['gluten'])) {
    $Zutaten4 = " AND Z.Gluten = 'true' ";
}
else{
    $Zutaten4 = "";
}

$query = $query_begin . $bilder1 . $kategorie1 . $Zutaten1 . $where . $kategorie2 . $Zutaten2 . $Zutaten3 .$Zutaten4 . $avail1 . $limit1;

echo $query;
*/
/*
if(!isset($_GET['avail'])) {
    $_POST['avail'] = '\'%\'';
}
if(!isset($_GET['limit'])) {
    $_GET['limit'] = 8;
}
if(!isset($_GET['kategorien']) || $_GET['kategorien'] == "") {
    $_POST['kategorien'] = '\'%\'';
}

if(isset($_GET['vegan']) && $_GET['vegan'] == 1 && !isset($_GET['vegetarisch'])) {
    $indexName = "VeganIndex";
    $index = 0;
} else if(isset($_GET['vegetarisch']) && $_GET['vegetarisch'] == 1 && !isset($_GET['vegan'])) {
    $indexName = "VeggieIndex";
    $index = 0;
} else if(isset($_GET['vegan']) && $_GET['vegan'] == 1 && isset($_GET['vegetarisch']) && $_GET['vegetarisch'] == 1) {
    $indexName = "VeganIndex";
    $index = 0;
} else {
    $indexName = "VeggieIndex";
    $index = '\'%\'';
}
$query = 'SELECT m.ID, m.Name, m.inKategorie, m.Verfügbar, 
                                                            (COUNT(z.ID) - SUM(z.Vegan)) AS VeganIndex, 
                                                            (COUNT(z.ID) - SUM(z.Vegetarisch)) AS VeggieIndex, 
                                                            b.ID AS BildID, b.`Alt-Text`, b.Titel, b.Binärdaten
                                                            FROM Mahlzeiten AS m
                                                            LEFT JOIN MahlzeitenEnthaltenZutaten MEZ ON m.ID = MEZ.ID_M
                                                            LEFT JOIN Zutaten z on MEZ.ID_Z = z.ID
                                                            LEFT JOIN MahlzeitenHabenBilder MHB ON m.ID = MHB.ID_M
                                                            LEFT JOIN Bilder AS b ON MHB.ID_B = b.ID
                                                            WHERE b.Titel LIKE \'%\' AND m.Verfügbar LIKE '.$_POST['avail'].' AND m.inKategorie LIKE '.$_POST['kategorien'].'
                                                            GROUP BY m.ID
                                                            HAVING '.$indexName.' LIKE '.$index.'
                                                            LIMIT '.$_GET['limit'];

echo $query;
*/
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
    $query .= ' AND (M.inKategorie = \''.$_POST['kategorien'].'\')';
}
$query .= ' GROUP BY M.ID';

if (isset($_POST['vegetarisch']) && !isset($_POST['vegan'])){
    $query .= ' HAVING (VegetarischIndex = 0)';
}
else if (isset($_POST['vegan']) && !isset($_POST['vegetarisch'])){
    $query .= ' HAVING (VeganIndex = 0)';
}
else if (isset($_POST['vegetarisch']) && isset($_POST['vegan'])) {
    $query .= ' HAVING (VegetarischIndex = 0) AND (VeganIndex = 0)';
}
$query .= ' ORDER BY M.inKategorie, M.Name';

if (isset($_GET['limit'])) {
    $query .= ' LIMIT '.$_GET['limit'];
}

//echo $query;

$result = mysqli_query($remoteConnection, $query);

//$query2 ="select Kategorien.ID, Kategorien.Bezeichnung, Kategorien.hatKategorie FROM Kategorien ORDER BY Kategorien.hatKategorie ASC";
//$query2 = "select Kategorien.ID, Kategorien.Bezeichnung, Kategorien.hatKategorie From Kategorien where Kategorien.hatKategorie is null OR Kategorien.ID in (SELECT inKategorie FROM Mahlzeiten Where Verfügbar = true) ORDER BY Kategorien.hatKategorie ASC";
$query2="select Kategorien.ID, Kategorien.Bezeichnung, Kategorien.hatKategorie From Kategorien where Kategorien.hatKategorie is null OR Kategorien.ID in (SELECT inKategorie FROM Mahlzeiten) ORDER BY Kategorien.hatKategorie ASC";

$result2 = mysqli_query($remoteConnection, $query2);

$array = array();
$array2 = 'Alle zeigen';

while ($row2 = mysqli_fetch_assoc($result2))
{
    array_push($array, array("ID" => $row2['ID'], "Bezeichnung" => $row2['Bezeichnung'], "hatKategorie" => $row2['hatKategorie']));

    if(isset($_POST['kategorien']) && $row2['ID'] == $_POST['kategorien'])
    {
        $array2 = $row2['Bezeichnung'];
    }

}

$data = array();

while ($row = mysqli_fetch_assoc($result))
{
    array_push($data, array("ID" => $row['ID'], "Name" => $row['Name'], "Verfügbar" => $row['Verfügbar'], "Binärdaten" => base64_encode($row['Binärdaten'])));
}
/*foreach ($array as $arra)
{
    echo $arra['Bezeichnung'];
    echo $arra['hatKategorie'];
}
*/
$variables = array();

//echo $_POST['avail'];
//echo $_POST['vegetarisch'];
//echo $_POST['vegan'];

                   echo '</select>';
                   if(isset($_POST["avail"]) && $_POST["avail"] == '1'){
                       $variables['avail'] = true;
                   } else {
                       $variables['avail'] = false;
                   }

                   if(isset($_POST['vegetarisch'])&& $_POST["vegetarisch"] == '1'){
                       $variables['vegetarisch'] = true;
                   } else {
                       $variables['vegetarisch'] = false;
                   }

                   if(isset($_POST['vegan']) && $_POST["vegan"] == '1'){
                       $variables['vegan'] = true;
                   } else {
                       $variables['vegan'] = false;
                   }

                    if(isset($_POST['kategorien'])){
                        $variables['kategorien'] = $_POST['kategorien'];
                    } else {
                        $variables['kategorien'] = '-1';
                    }

                   /*
//for($j = 0;$j <= 2;$j++)
    //{

        echo '<div class="row text-center">';
            //for($i = 0;$i <4;$i++)
                //{
                    while ($row = mysqli_fetch_assoc($result)) {

                        /*$value = $row['ID'];
                        $query1 = "SELECT Mahlzeiten.ID, B.Binärdaten FROM Mahlzeiten
                        LEFT JOIN MahlzeitenHabenBilder MHB on Mahlzeiten.ID = MHB.ID_M
                        LEFT JOIN Bilder B on MHB.ID_B = B.ID
                        WHERE Mahlzeiten.ID = $value";
                        $result1 = mysqli_query($remoteConnection, $query1);
                        $row1 = mysqli_fetch_assoc($result1); // /
                        if ($row['Verfügbar']) {
                            echo '<div class="col-3 mb-2 mt-2 p-0">
                                    <div class="col "><img class="img mw-100 preview" alt="platzhalter" src="data:image/jpeg;base64,' . base64_encode($row['Binärdaten']) . '"></div>
                                     <div class="col "><a>' . $row['Name'] . '</a></div>
                                     <div class="col "><a class="fh_color" href="Detail.php?id=' . $row['ID'] . '"> Details</a></div>
                                    </div>';
                        } else {
                            echo '<div class="col-3 mb-2 mt-2 p-0 passdout">
                                     <div class="col"><img class="img mw-100 preview" alt="platzhalter" src="data:image/jpeg;base64,' . base64_encode($row['Binärdaten']) . '"></div>
                                     <div class="col"><a>' . $row['Name'] . '</a></div>
                                     <div class="col "><a class="fh_color" > Vergriffen</a></div>
                                     </div>';
                        }
                    }
                    */

echo $blade->run("produkte",array("array"=>$data, "variables" => $variables, "kat" => $array, "array2"=> $array2));

mysqli_close($remoteConnection);
