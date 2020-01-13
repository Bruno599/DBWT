<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class details extends Model
{
    public static function login_check($benutzer){

        $query4 = "select B.Nummer, B.Hash, B.Vorname, B.Nachname, NR.Rolle from Benutzer B, Nutzerrollen NR WHERE B.Nutzername = '$benutzer' AND B.Nummer = NR.Nummer";
        //$result4 = mysqli_query($remoteConnection, $query4);
        $result4 = DB::select($query4);

        return $result4;
    }

    public static function update_user($benutzer){
        $query_timestamp = "Update Benutzer B set `Letzter Login` = current_timestamp WHERE B.Nutzername = '$benutzer'";

        DB::update($query_timestamp);
    }

    public static function get_zutaten($value){
        $query2 = "select Z.Name FROM Zutaten Z left join MahlzeitenEnthaltenZutaten MEZ on Z.ID = MEZ.ID_Z left join Mahlzeiten M on MEZ.ID_M = M.ID WHERE M.ID = '".$value['id']."'";
        $result2 = DB::select($query2);

        return $result2;
    }
    public static function get_comment($value){

        $query3 = "SELECT  K.Bemerkung, K.Bewertung, K.Zeitpunkt, B.Nutzername FROM Kommentare K
                    LEFT JOIN Studenten S on K.GeschriebenVon = S.Nummer
                    LEFT JOIN `FH Angehoerige` `F A` on S.Nummer = `F A`.Nummer
                    LEFT JOIN Benutzer B on `F A`.Nummer = B.Nummer
                    WHERE K.GehörtZu = $value ORDER BY Zeitpunkt DESC";

        $result3 = DB::select($query3);

        return $result3;
    }
}
