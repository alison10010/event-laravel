<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\EventController;  // IMPORTA O CONTROLE COM O NOME EVENTCONTROLER DA PASTA CONTROLLER

Route::get('/', [EventController::class, 'index']); // PAGINA PRINCIPAL

Route::get('/events/create', [EventController::class, 'create'])->middleware('auth'); // PAGINA PARA CRIAR UM EVENTO PRECISA TÁ LOGADO

Route::post('/events', [EventController::class, 'store']); // ROTA DE POST PARA SALVA UM UM EVENTO

Route::get('/events/{id}', [EventController::class, 'show']); // PAGINA PARA DETALHE DE UM EVENTO

Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth'); // ROTA PARA EXCLUIR UM EVENTO

Route::get('/events/edit/{id}', [EventController::class, 'edit'])->middleware('auth'); // ROTA PARA VER OS DADOS P/ REALIZAR A EDIÇÃO DE EVENTO

Route::put('/events/update/{id}', [EventController::class, 'update'])->middleware('auth'); // REALIZA A EDICAO DO EVENTO

// ROTA PARA A PAGINA CONTATO
Route::get('/contato', function () {
    return view('contato');
});

Route::get('/dashboard', [EventController::class, 'dashboard'])->middleware('auth'); // APOS LOGAR VAI PARA DASHBOARD

Route::post('/events/join/{id}', [EventController::class, 'joinEvent'])->middleware('auth');  // PARTICIPA DE UM EVENTO

Route::delete('/events/cancelarParticipacao/{id}', [EventController::class, 'cancelarParticipacao'])->middleware('auth');