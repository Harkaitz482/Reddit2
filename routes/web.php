<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

Route::post('community', [App\Http\Controllers\CommunityLinkController::class, 'store'])->middleware('auth');
Route::get('community/{channel:slug}', [App\Http\Controllers\CommunityLinkController::class, 'index']);

Route::get('/consultas', function () {
    // Consulta 1: Todos los users que tengan en el nombre la cadena "Fer"
    $users1 = DB::table('users')->where('name', 'like', '%fer%')->get();

    // Consulta 2: Todos los users que tengan en el correo la palabra "laravel" y la cadena "com"
    $users2 = DB::table('users')->where([
        ['email', 'like', '%laravel%'],
        ['email', 'like', '%com%'],
    ])->get();

    // Consulta 3: Todos los users que tengan en el correo la palabra "laravel" o la palabra "com"
    $users3 = DB::table('users')
        ->where('email', 'like', '%laravel%')
        ->orWhere('email', 'like', '%com%')
        ->get();

    // Consulta 5: Insertar dos usuarios a la vez en la tabla users
    $insert=DB::table('users')->insert([['name' => 'Prim3er Usuario','email' => 'usuario31@ejemplo.com','password' => bcrypt('contraseña1'),],['name' => 'Segun43do Usuario','email' => 'usuario2@e43jemplo.com','password' => bcrypt('contraseña2'), ],]);

    // Consulta 6: Insertar un usuario utilizando el método insertGetId
    $userId = DB::table('users')->insertGetId([ 'name' => 'Nuevo Usuario','email' => 'nuevo@ejemplo.com','password' => bcrypt('contraseña'),]);


    // Consulta 7: Actualizar el correo del usuario con id=2
    $updateResult = DB::table('users')->where('id', 2)->update(['email' => 'new@laravel.com']);

    // Consulta 8: Borrar el usuario con id=3
    $deleteResult = DB::table('users')->where('id', 3)->delete();

    // Devolver los resultados
    return [
        'users1' => $users1,
        'users2' => $users2,
        'users3' => $users3,
        'insertedId' => $userId,
        'insertedId2' => $insert,
        'updateResult' => $updateResult,
        'deleteResult' => $deleteResult,
    ];
});
