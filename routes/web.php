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
    echo 'test';
    return view('welcomePool');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/competitions', 'API\External\FootballDataController@showCompetitions');
Route::get('/competitions/{year}', function ($year) {
    $fc  = new App\Http\Controllers\API\External\FootballDataController();
    return $fc->showCompetitions($year);
});
Route::get('/competition/fixtures', function () {
    $cc  = new \App\Http\Controllers\Core\CompetitionController(449);
    return $cc->fixtures();
});
Route::get('/competition/standings', function () {
    $cc  = new \App\Http\Controllers\Core\CompetitionController(449);
    return $cc->standings();
});
Route::resource('tournament', 'Core\TournamentController');
//Route::resource('competition', 'Core\CompetitionController');
Route::resource('route', 'RouteController');
Route::resource('todo','todocontroller');

