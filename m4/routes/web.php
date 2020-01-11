<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages/start');
});


/*
Route::get('/Start', function () {
    return view('start');
});
*/

Route::get('/Start.php', 'StartController@show');
Route::get('/Zutaten.php', 'zutatenController@show');
Route::any('/Produkte.php', 'mahlzeitenController@show');
Route::match(['get', 'post'],'/Detail.php', 'detailsController@show');
Route::get('/Bewertung/{ID}', 'bewertungsController@show');
Route::Post('/Bewertung', 'bewertungsController@insert');



