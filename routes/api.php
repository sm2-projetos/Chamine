<?php

use Illuminate\Support\Facades\Route;

Route::post('/salvar-imagens', [\App\Http\Controllers\Api\ImagemController::class, 'store']);