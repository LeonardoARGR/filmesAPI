<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmeApiController;

// Rotas para visualizar os registros
Route::get('/', function(){return response()->json(['Sucesso'=>true]);});
Route::get('/filme', [FilmeApiController::class, 'index']);
Route::get('filme/{codigo}', [FilmeApiController::class, 'show']);

// Rota para inserir os registros
Route::post('/filme', [FilmeApiController::class, 'store']);

// Rota para alterar os registros
Route::put('/filme/{codigo}', [FilmeApiController::class, 'update']);

// Rota para excluir os registros
Route::delete('/filme/{codigo}', [FilmeApiController::class, 'destroy']);
