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
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\SalvarImagensController;
use App\Http\Controllers\LegislacaoController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\InfraestruturaController;
use App\Http\Controllers\MetodologiaController;
use App\Models\Infraestrutura;
use App\Models\Metodologia;

Route::get('/formulario', function () {
    return view('formulario');
});

Route::get('/formulario-index', [FormularioController::class, 'index'])->name('formulario.index');

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
    Route::resource('empresas', EmpresasController::class);
    Route::get('/empresas-checkcnpj', [EmpresasController::class, 'checkCnpj'])->name('empresas.checkcnpj');

    // Rotas para propostas comerciais
    Route::get('/propostas/create', [PropostasController::class, 'create'])->name('propostas.create');
    Route::post('/propostas', [PropostasController::class, 'store'])->name('propostas.store');
    Route::get('/propostas/show', [PropostasController::class, 'show'])->name('propostas.show');
    Route::get('/propostas/os/{id}', [PropostasController::class, 'os'])->name('propostas.os');
    Route::resource('propostas', PropostasController::class);

    // Rota para buscar perfis por empresa
    Route::post('/perfis/getProfilesByEmpresa', [PerfilController::class, 'getProfilesByEmpresa'])->name('perfis.getProfilesByEmpresa');

    // Rota para o formulário de criação de OS
    Route::get('/os/criar/{id}', [OSController::class, 'create'])->name('os.criar');
    Route::get('/os/show/{id}', [OSController::class, 'showOS'])->name('os.showos');
    Route::post('/os', [OSController::class, 'store'])->name('os.store'); // Adicione esta linha
    Route::resource('os', OSController::class);
    Route::get('/os/{id}/form', [OSController::class, 'showForm'])->name('os.form');
    Route::post('/os/{perfilId}/generatePDF', [PDFController::class, 'generatePDF'])->name('os.generatePDF');

    Route::get('/generate-pdf', [PDFController::class, 'generatePDF']);

    Route::post('/generate-document', [DocumentController::class, 'generateDocument'])->name('generate.document');

    Route::post('/store-certificado', [FormularioController::class, 'storeCertificado'])->name('certificado.store');
    Route::get('/certificado', [FormularioController::class, 'certificado'])->name('certificado.index');
    Route::put('/certificado-makePrimary/{id}', [FormularioController::class, 'makePrimary'])->name('certificado.makePrimary');
    Route::delete('/certificado-destroy', [FormularioController::class, 'destroyCertificado'])->name('certificado.destroy');

    // Rotas para geração de documentos
    Route::get('/documents/form', [DocumentController::class, 'showForm'])->name('documents.form');
    Route::post('/get-placeholders', [DocumentController::class, 'getPlaceholders'])->name('get.placeholders');
    Route::post('/generate-document', [DocumentController::class, 'generateDocument'])->name('generate.document');

    Route::get('/legislacao', [LegislacaoController::class, 'index'])->name('legislacao.index');
    Route::post('/legislacao-store', [LegislacaoController::class, 'store'])->name('legislacao.store');
    Route::put('/legislacao-update/{id}', [LegislacaoController::class, 'update'])->name('legislacao.update');
    Route::delete('/legislacao-destroy/{id}', [LegislacaoController::class, 'destroy'])->name('legislacao.destroy');

    Route::get('/equipamentos/create', [EquipamentoController::class, 'create'])->name('equipamentos.create');
    Route::post('/equipamentos', [EquipamentoController::class, 'store'])->name('equipamentos.store');
    
    Route::get('/infraestruturas/create', [InfraestruturaController::class, 'create'])->name('infraestruturas.create');
    Route::post('/infraestruturas', [InfraestruturaController::class, 'store'])->name('infraestruturas.store');

    Route::get('/metodologias/create', [MetodologiaController::class, 'create'])->name('metodologias.create');
    Route::post('/metodologias/store', [MetodologiaController::class, 'store'])->name('metodologias.store');
    Route::get('/metodologias', [MetodologiaController::class, 'index'])->name('metodologias.index');

    
    
});

    // Route::post('/salvar-imagens', [SalvarImagensController::class, 'salvar']);
    // Route::get('/imagem-privada/{nome}', function ($nome) {
    //     $path = storage_path('app/privado/imagens/' . $nome);

    //     if (!file_exists($path)) {
    //         abort(404);
    //     }

    //     return response()->file($path);
    // });