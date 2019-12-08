<?php
include "snippets/mysqlconnect.php";


$query_begin = "select M.ID, M.Name, M.Verfügbar FROM Mahlzeiten M";

if(isset($_POST['limit']))
{
    $limit1 = "LIMIT ".$_POST['limit'];
}
else
{
    $limit1 = "";
}

if (isset($_POST['kategorien']) || isset($_POST['vegan']) || isset($_POST['vegetraisch']) || isset($_POST['gluten']) || isset($_POST['avail'])){
    $where = "WHERE M.ID != 0";
}else{
    $where = "";
}

if (isset($_POST['avail'])) {
    $avail1 = "AND M.Verfügbar = true";
}else{
    $avail1 = "";
}

if(isset($_POST['kategorie']))
{
    $kategorie1 = "LEFT JOIN Kategorien K ON K.ID = M.inKategorie";
    $kategorie2 = " AND K.ID = '*'";
}
else
{
    $kategorie1 = "";
    $kategorie2 = "";
}

if(isset($_POST['vegan']) || isset($_POST['vegetraisch']) || isset($_POST['gluten'])){
    $Zutaten1 = "LEFT JOIN MahlzeitenEnthaltenZutaten MEZ on M.ID = MEZ.ID_M LEFT JOIN Zutaten Z on MEZ.ID_Z = Z.ID";
}
else{
    $Zutaten1 = "";
}

if (isset($_POST['vegan'])) {
    $Zutaten2 = "AND Z.Vegan = 'true'";
}
else {
    $Zutaten2 = "";
}

if (isset($_POST['vegetarisch'])) {
    $Zutaten3 = " AND Z.Vegetarisch = 'true'";
}
else {
    $Zutaten3 = "";
}

if(isset($_POST['gluten'])) {
    $Zutaten4 = " AND Z.Gluten = 'true'";
}
else{
    $Zutaten4 = "";
}

$query = $query_begin . $kategorie1 . $Zutaten1 . $where . $kategorie1 . $Zutaten2 . $Zutaten3 .$Zutaten4 . $avail1 . $limit1;

function Produkte_find_by_values($kategorie, $vegan, $vegetarisch, $avail): array {
    return db_query_assoc_single(
        if($kategorie != "alles_Anzeigen" )
    {
        if ($vegan == true)
    }
    )
}

function Produkte_find_by_value_vegan(): array {
    return db_query_assoc_single(
        "Select Z.ID From Zutaten Z WHERE Z.Vegan = true"
    );
}

function Pr





$query = "select M.ID, M.Name, M.Verfügbar FROM Mahlzeiten M
LEFT JOIN Kategorien K ON K.ID = M.inKategorie
LEFT JOIN MahlzeitenEnthaltenZutaten MEZ on M.ID = MEZ.ID_M
LEFT JOIN Zutaten Z on MEZ.ID_Z = Z.ID
WHERE EXISTS (select * FROM Mahlzeiten M WHERE M.
AND Z.Vegan = '*' 
AND Z.Vegetarisch = '*' 
AND K.ID = '*'";


