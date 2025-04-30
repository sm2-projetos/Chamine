@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Gerar Documento</h2>

        {{-- Debug --}}
        @if(count($templates) === 0)
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                <p>Nenhum template encontrado em: {{ storage_path('app/templates') }}</p>
                <p>Por favor, verifique se:</p>
                <ul class="list-disc ml-5 mt-2">
                    <li>A pasta existe</li>
                    <li>Contém arquivos .docx</li>
                    <li>As permissões estão corretas</li>
                </ul>
            </div>
        @endif

        <form action="{{ route('generate.document') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
            @csrf
            
            <div>
                <label for="template_name" class="block text-sm font-medium text-gray-700">Template</label>
                <select name="template_name" id="template_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Selecione um template</option>
                    @foreach($templates as $template)
                        <option value="{{ $template }}">{{ $template }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-4">
                {{-- Informações do Cliente --}}
                <div class="border-b pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informações do Cliente</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nomeCliente" class="block text-sm font-medium text-gray-700">Nome do Cliente</label>
                            <input type="text" name="data[nomeCliente]" id="nomeCliente" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="nRelatorio" class="block text-sm font-medium text-gray-700">Número do Relatório</label>
                            <input type="text" name="data[nRelatorio]" id="nRelatorio" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="nomeDoProcesso" class="block text-sm font-medium text-gray-700">Nome do Processo</label>
                            <input type="text" name="data[nomeDoProcesso]" id="nomeDoProcesso" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="empresaCliente" class="block text-sm font-medium text-gray-700">Empresa do Cliente</label>
                            <input type="text" name="data[empresaCliente]" id="empresaCliente" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="cepEmpresa" class="block text-sm font-medium text-gray-700">CEP da Empresa</label>
                            <input type="text" name="data[cepEmpresa]" id="cepEmpresa" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="cnpjEmpresa" class="block text-sm font-medium text-gray-700">CNPJ da Empresa</label>
                            <input type="text" name="data[cnpjEmpresa]" id="cnpjEmpresa" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="cidadeCliente" class="block text-sm font-medium text-gray-700">Cidade do Cliente</label>
                            <input type="text" name="data[cidadeCliente]" id="cidadeCliente" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="dataColeta" class="block text-sm font-medium text-gray-700">Data da Coleta</label>
                            <input type="date" name="data[dataColeta]" id="dataColeta" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>

                {{-- Informações Técnicas --}}
                <div class="border-b pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informações Técnicas</h3>
                    
                    <div>
                        <label for="tecnicos" class="block text-sm font-medium text-gray-700">Técnicos Responsáveis</label>
                        <input type="text" name="data[tecnicos]" id="tecnicos" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="mt-4">
                        <label for="textDeObjetivoEspecifico" class="block text-sm font-medium text-gray-700">Objetivo Específico</label>
                        <textarea name="data[textDeObjetivoEspecifico]" id="textDeObjetivoEspecifico" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="mt-4">
                        <label for="listaMetodologiasEmpregadas" class="block text-sm font-medium text-gray-700">Metodologias Empregadas</label>
                        <textarea name="data[listaMetodologiasEmpregadas]" id="listaMetodologiasEmpregadas" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                </div>

                {{-- Informações do Processo --}}
                <div class="border-b pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informações do Processo</h3>
                    
                    <div>
                        <label for="tituloTabelaProcessoIndustrial" class="block text-sm font-medium text-gray-700">Título da Tabela do Processo Industrial</label>
                        <input type="text" name="data[tituloTabelaProcessoIndustrial]" id="tituloTabelaProcessoIndustrial" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="mt-4">
                        <label for="textoLegislacaoEmVigor1" class="block text-sm font-medium text-gray-700">Legislação em Vigor (Parte 1)</label>
                        <textarea name="data[textoLegislacaoEmVigor1]" id="textoLegislacaoEmVigor1" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="mt-4">
                        <label for="textoLegislacaoEmVigor2" class="block text-sm font-medium text-gray-700">Legislação em Vigor (Parte 2)</label>
                        <textarea name="data[textoLegislacaoEmVigor2]" id="textoLegislacaoEmVigor2" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                </div>

                {{-- Imagens --}}
                <div class="border-b pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Imagens</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @for($i = 1; $i <= 26; $i++)
                            <div>
                                <label for="imagem{{ $i }}" class="block text-sm font-medium text-gray-700">Imagem {{ $i }}</label>
                                <input type="file" name="imagens[imagem{{ $i }}]" id="imagem{{ $i }}" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <p class="mt-1 text-sm text-gray-500">Formatos aceitos: JPG, PNG, GIF</p>
                            </div>
                        @endfor
                    </div>
                </div>

                {{-- Resultados e Conclusões --}}
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Resultados e Conclusões</h3>
                    
                    <div>
                        <label for="tituloTabelaResultados" class="block text-sm font-medium text-gray-700">Título da Tabela de Resultados</label>
                        <input type="text" name="data[tituloTabelaResultados]" id="tituloTabelaResultados" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="mt-4">
                        <label for="textoObsConclusaoMaterialParticulado" class="block text-sm font-medium text-gray-700">Observações e Conclusão - Material Particulado</label>
                        <textarea name="data[textoObsConclusaoMaterialParticulado]" id="textoObsConclusaoMaterialParticulado" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="mt-4">
                        <label for="textoObsConclusaoMonoxidoCarbono" class="block text-sm font-medium text-gray-700">Observações e Conclusão - Monóxido de Carbono</label>
                        <textarea name="data[textoObsConclusaoMonoxidoCarbono]" id="textoObsConclusaoMonoxidoCarbono" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Gerar Documento
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 