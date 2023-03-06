<?php

//import controllers
use App\Http\Controllers\UserController;
use App\Http\Controllers\AcoesController;
//import models
use App\Models\Acoes;

//Import de outras resources
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Facade\Ignition\Solutions\UseDefaultValetDbCredentialsSolution;
use Yajra\DataTables\Facades\DataTables;

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
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth');


//-----------------------------------------------------------------------USER ROTAS-----------------------------------------------------------------------------------------------------
//atualizar palavra passe primeira vez que entram->mostrar view
Route::get('/user/changepassword/', [UserController::class,'updatePassword'])->middleware('auth');
//atualizar bdf
Route::post('/user/updatepassword', [UserController::class,'editpassword'])->middleware('auth');
//mostrar utilizadores caso haja permisao

Route::get('/user/all/{estado}', [UserController::class,'index'])->middleware('auth');


//give permission
Route::get('/user/givepermission/{iduser}', [UserController::class,'givePermission'])->middleware('auth');
//remove
Route::get('/user/removepermission/{iduser}', [UserController::class,'removePermission'])->middleware('auth');
//user update mostrar view
Route::get('/user/update/{iduser}', [UserController::class,'update'])->middleware('auth');
//update do utilizador
Route::post('/user/edit/{iduser}', [UserController::class,'edit'])->middleware('auth');
//-----------------------------------------------------------------------AÇÕES ROTAS-----------------------------------------------------------------------------------------------------
//Mostrar minhas ações

Route::get('/acoes/minhasacoes/{estado}', [AcoesController::class, 'indexminhasacoes'])->middleware('auth');

//Mostrar minhas ações
Route::get('/acoes/all/{estado}', [AcoesController::class, 'index'])->middleware('auth');

//mmostrar criar aoes
Route::get('/acoes/create', [AcoesController::class, 'create'])->middleware('auth');
//criar acoes na db
Route::post('/acoes/store', [AcoesController::class, 'store'])->middleware('auth');
//mostrar detalhes da acao
Route::get('/acoes/details/{idissue}', [AcoesController::class, 'show'])->middleware('auth');
//mostrar detalhes da acao
Route::post('/acoes/remark/store', [AcoesController::class, 'storeRemark'])->middleware('auth');
//gerir estado da issue->concluded ou nao
Route::post('/acoes/condition/concluded', [AcoesController::class, 'changetoconcluded'])->middleware('auth');
//gerir estado da issue->cancelled ou nao
Route::post('/acoes/condition/cancelled', [AcoesController::class, 'changetocancelled'])->middleware('auth');
//mostrar view para editar a issue
Route::get('/acoes/edit/{idissue}', [AcoesController::class, 'edit'])->middleware('auth');
//mostrar view para editar a issue
Route::post('/acoes/update/{idissue}', [AcoesController::class, 'update'])->middleware('auth');
//novo input
Route::post('/acoes/input/store', [AcoesController::class, 'storeInput'])->middleware('auth');
//novo dpto
Route::post('/acoes/dpto/store', [AcoesController::class, 'storeDpto'])->middleware('auth');
//novo input
Route::post('/acoes/local/store', [AcoesController::class, 'storeLocal'])->middleware('auth');
//reverter concluido para processing
Route::get('/acoes/revert/concluded/{idissue}', [AcoesController::class, 'revertConcluded'])->middleware('auth');
//reverter cancelado para processing
Route::get('/acoes/revert/cancelled/{idissue}', [AcoesController::class, 'revertCancelled'])->middleware('auth');

//-----------------------------------------------------------------------OUTRAS ROTAS------------------------------------------------------------
Route::get('/admin/priority', [AcoesController::class, 'PrioritytoNumber'])->middleware('auth');

//-----------------------------------------------------------------------AUTH ROTAS-----------------------------------------------------------------------------------------------------
Auth::routes();



