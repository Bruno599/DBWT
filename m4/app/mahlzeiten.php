<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class mahlzeiten extends Model
{
    public static function produkte($test,$test2){

        $query = "SELECT M.ID, M.Name, M.`Verfügbar`, M.inKategorie, (COUNT(Z.ID) - SUM(Z.Vegan)) AS VeganIndex, 
        (COUNT(Z.ID) - SUM(Z.Vegetarisch)) AS VegetarischIndex, B.`Alt-Text`, B.`Binärdaten` 
        FROM Mahlzeiten M 
        LEFT JOIN MahlzeitenHabenBilder MHB ON M.ID = MHB.ID_M 
        LEFT JOIN Bilder B ON MHB.ID_B = B.ID 
        LEFT JOIN MahlzeitenEnthaltenZutaten MEZ ON M.ID = MEZ.ID_M 
        LEFT JOIN Zutaten Z on MEZ.ID_Z = Z.ID
        WHERE B.`Alt-Text` != '0'";

        if (isset($test['avail'])) {
            $query .= ' AND (M.`Verfügbar` = 1)';
        }

        if (isset($test['kategorien']) && $test['kategorien'] != '-1') {
            $query .= ' AND (M.inKategorie = \'' . $test['kategorien'] . '\')';
        }
        $query .= ' GROUP BY M.ID';

        if (isset($test['vegetarisch']) && !isset($test['vegan'])) {
            $query .= ' HAVING (VegetarischIndex = 0)';
        } else if (isset($test['vegan']) && !isset($test['vegetarisch'])) {
            $query .= ' HAVING (VeganIndex = 0)';
        } else if (isset($test['vegetarisch']) && isset($test['vegan'])) {
            $query .= ' HAVING (VegetarischIndex = 0) AND (VeganIndex = 0)';
        }
        $query .= ' ORDER BY M.inKategorie, M.Name';

        if (isset($test2['limit'])) {
            $query .= ' LIMIT ' . $test2['limit'];
        }

        $result = DB::select($query);

        return $result;
    }

    public static function kategorien(){

        $query2 = "select Kategorien.ID, Kategorien.Bezeichnung, Kategorien.hatKategorie From Kategorien where Kategorien.hatKategorie is null OR Kategorien.ID in (SELECT inKategorie FROM Mahlzeiten) ORDER BY Kategorien.hatKategorie ASC";

        $result2 = DB::select($query2);

        return $result2;

    }
}
