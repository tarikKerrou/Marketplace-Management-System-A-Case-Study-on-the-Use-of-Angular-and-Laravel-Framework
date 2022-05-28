<?php
use App\Http\Controllers\ProduitsController;
use App\Models\Produits;
use Illuminate\Http\Controllers\UtulisateurController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//les routes de produites
Route::any('add', [ProduitsController::class,'add']);
Route::any('update','ProduitsController@update');
Route::any('delete','ProduitsController@delete');
Route::any('show',[ProduitsController::class,'show'])->name('show');
// Les routes d'utilisateur 
Route::any('register','UtulisateurController@register');
Route::any('login','UtulisateurController@login');