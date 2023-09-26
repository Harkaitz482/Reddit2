<?php

use Faker\Core\Number;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});
Auth::routes(['verify' => 'true']);
Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

Route::get('community', [App\Http\Controllers\CommunityLinkController::class, 'index']);

Route::post('community', [App\Http\Controllers\CommunityLinkController::class, 'store']);




Route::get('/testeo', function () {
    return 'Hello World';
});

Route::get('numeros/{numero?}', function (?string $numero = "1") {


    return "Mostrando el numero $numero";
});

Route::post('/ruta/{nombre?}', function (?string $nombre = "1") {


    return "post";
});



Route::match(['get', 'post'], 'userGetpost', function (?string $nombre = "1"){
    return 'esta bien ';

});

Route::get('validar/{numero}', function ($numero) {
    if (is_numeric($numero)) {
        return "El parámetro es un número: $numero";
    } else {
        return "El parámetro no es un número válido.";
    }
})->where('numero', '[0-9]+');


Route::get('validar/{letras}/{numeros}', function ($letras, $numeros) {
    if (ctype_alpha($letras) && is_numeric($numeros)) {
        return "Parámetros válidos: letras = $letras, números = $numeros";
    } else {
        return "Parámetros no válidos.";
    }
});




Route::get('/host', function () {
    $dbHost = env('DB_HOST');
    return "La dirección IP de la base de datos es: $dbHost";
});

