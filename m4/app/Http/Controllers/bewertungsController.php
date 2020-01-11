<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produkt;
use Illuminate\Support\Facades\DB;

class bewertungsController extends Controller
{

    public function show($ID)
    {
        $query = "SELECT K.Bemerkung, K.Bewertung, K.Zeitpunkt, B.Nutzername FROM Kommentare K
                    LEFT JOIN Studenten S on K.GeschriebenVon = S.Nummer
                    LEFT JOIN `FH Angehoerige` `F A` on S.Nummer = `F A`.Nummer
                    LEFT JOIN Benutzer B on `F A`.Nummer = B.Nummer
                    WHERE K.GehörtZu = $ID ORDER BY Zeitpunkt DESC LIMIT 5";
        $result = DB::select($query);

        return view('pages.bewertung', $result);
    }

    public static function insert($mahlzeitID, $benutzerID, $bewertung, $bemerkung)
    {

        $query = "INSERT INTO Kommentare (Bemerkung, Bewertung, GeschriebenVon, GehörtZu, Zeitpunkt) VALUES ('$bemerkung', $bewertung, $benutzerID, $mahlzeitID,now())";
        $DB = DB::insert($query);
        //echo $query;

    }
}
