<?php

namespace App\Http\Controllers;

require_once "../vendor/autoload.php";

use App\zutatenmodell;
use Illuminate\Http\Request;
use App\Produkt;
use Illuminate\Support\Facades\DB;

class zutatenController extends Controller
{
    public function show(){
       //$data =  DB::select('SELECT Name,Bio,Vegetarisch,Vegan,Glutenfrei FROM Zutaten ORDER BY bio DESC ,Name ASC');
        //$count = DB::select('SELECT COUNT(*) AS num FROM Zutaten');

        $data = zutatenmodell::zutaten();
        $count = zutatenmodell::anzahl();

        //var_dump($count);
        //var_dump($data);

        return view('pages.zutaten', ['zutaten'=>$data, 'anzahl' => $count[0]->num]);
    }
}
