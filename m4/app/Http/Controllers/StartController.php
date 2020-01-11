<?php

namespace App\Http\Controllers;

require_once "../vendor/autoload.php";

//require_once "model/zutatenModel.php";

use Illuminate\Http\Request;

class StartController extends Controller
{
    public function show(){
        return view('pages.start');
    }
}
