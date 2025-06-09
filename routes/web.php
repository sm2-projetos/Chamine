<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\PropostasController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\OSController; // Adicione esta linha
use App\Http\Controllers\PDFController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\DocumentController;

Route::get('/formulario', function () {
    return view('formulario');
});

Route::post('/gerar-documento', [DocumentoController::class, 'gerar']);


Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/formulario', function () {
    return view('formulario');
})->name('formulario');

Route::post('/gerar-documento', [DocumentoController::class, 'gerar'])->name('gerar.documento');



// Agrupar rotas protegidas
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    // Rotas para clientes
    Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/create', [ClientesController::class, 'create'])->name('clientes.create');
    Route::post('/clientes', [ClientesController::class, 'store'])->name('clientes.store');
    Route::post('/clientes/check-cpf', [ClientesController::class, 'checkCpf'])->name('clientes.checkCpf');
    Route::post('/clientes/get-client-data', [ClientesController::class, 'getClientData'])->name('clientes.getClientData');
    Route::get('/clientes/{id}/edit', [ClientesController::class, 'edit'])->name('clientes.edit');
    Route::put('/clientes/{id}', [ClientesController::class, 'update'])->name('clientes.update');
    Route::delete('/clientes/{id}', [ClientesController::class, 'destroy'])->name('clientes.destroy');

    // Rotas para empresas
    Route::get('/empresas', [EmpresasController::class, 'index'])->name('empresas.index');
    Route::get('/empresas/create', [EmpresasController::class, 'create'])->name('empresas.create');
    Route::post('/empresas', [EmpresasController::class, 'store'])->name('empresas.store');
    Route::get('/empresas/{id}/edit', [EmpresasController::class, 'edit'])->name('empresas.edit');
    Route::put('/empresas/{id}', [EmpresasController::class, 'update'])->name('empresas.update');
    Route::delete('/empresas/{id}', [EmpresasController::class, 'destroy'])->name('empresas.destroy');
    Route::resource('empresas', EmpresaController::class);

    // Rotas para propostas comerciais
    Route::get('/propostas/create', [PropostasController::class, 'create'])->name('propostas.create');
    Route::post('/propostas', [PropostasController::class, 'store'])->name('propostas.store');
    Route::resource('propostas', PropostasController::class);

    // Rota para buscar perfis por empresa
    Route::post('/perfis/getProfilesByEmpresa', [PerfilController::class, 'getProfilesByEmpresa'])->name('perfis.getProfilesByEmpresa');

    // Rota para o formulário de criação de OS
    Route::get('/os/create', [OSController::class, 'create'])->name('os.create');
    Route::post('/os', [OSController::class, 'store'])->name('os.store'); // Adicione esta linha
    Route::resource('os', OSController::class);
    Route::get('/os/{id}/form', [OSController::class, 'showForm'])->name('os.form');
    Route::get('/os', 'OsController@index')->name('os.index'); 

    Route::get('/os', function(){
        return view('os/create');
    });

    Route::post('/os/{perfilId}/generatePDF', [PDFController::class, 'generatePDF'])->name('os.generatePDF');

    Route::get('/generate-pdf', [PDFController::class, 'generatePDF']);

    Route::post('/generate-document', [DocumentController::class, 'generateDocument'])->name('generate.document');

    // Rotas para geração de documentos
    Route::get('/documents/form', [DocumentController::class, 'showForm'])->name('documents.form');
    Route::post('/get-placeholders', [DocumentController::class, 'getPlaceholders'])->name('get.placeholders');
    Route::post('/generate-document', [DocumentController::class, 'generateDocument'])->name('generate.document');

});