<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class zutatenmodell extends Model
{
    public  static function zutaten(){
        $data =  DB::select('SELECT Name,Bio,Vegetarisch,Vegan,Glutenfrei FROM Zutaten ORDER BY bio DESC ,Name ASC');

        return $data;

    }

    public static function anzahl(){

        $count = DB::select('SELECT COUNT(*) AS num FROM Zutaten');

        return $count;
    }
}
