@extends('adminlte::page')

@section('plugins.Select2', true)

@section('title', 'Gerador de Escalas')

@section('content')
    @php
        $config = [
            'placeholder' => 'Selecione os integrantes',
            'allowClear' => true,
        ];
    @endphp

    <body class="bg-light">
        <div class="container py-4">
            <h1 class="mb-4">Gerador de Escalas</h1>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Configurações</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Insira o nome" required>
                            </div>

                            <div class="mb-3">
                                <label for="weeks" class="form-label">Quantidade de Semanas</label>
                                <input type="number" class="form-control" name="weeks" id="weeks"
                                    placeholder="Insira a quantidade" required min="1">
                            </div>

                            <div class="mb-3">
                                <label for="integrantes" class="form-label">Integrantes</label>
                                <x-adminlte-select2 id="users" name="users[]" :config="$config" multiple>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" data-name="{{ $user->name }}">
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Selecione as Funções</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <select name="functions" id="functions" class="form-control mb-2">
                                    <option value="">Selecione uma função</option>
                                    @foreach ($scaleFunctions as $function)
                                        <option value="{{ $function->id }}">{{ $function->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button onclick="addFunction()" class="btn btn-outline-primary btn-sm mt-2">
                                <i class="fas fa-plus-circle"></i> Adicionar Função
                            </button>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div id="functions-list" class="mt-2">
                                        <!-- Lista de funções adicionadas -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button onclick="createWeeks()" class="btn btn-primary mt-3">
                Criar Semanas
            </button>
            <div id="weeks-container" class="mt-4">
                <!-- As semanas serão adicionadas aqui -->
            </div>
        </div>
    </body>
@stop

@section('js')
    <script>
        let functions = [];
        let selectedFunctions = new Set();

        function addFunction() {
            const functionsSelect = document.getElementById('functions');

            if (!functionsSelect.value) {
                alert("Por favor, selecione uma função.");
                return;
            }

            const functionId = functionsSelect.value;
            const functionName = functionsSelect.options[functionsSelect.selectedIndex].text;

            if (selectedFunctions.has(functionId)) {
                alert("Esta função já foi adicionada.");
                return;
            }

            selectedFunctions.add(functionId);
            functions.push({
                id: functionId,
                name: functionName
            });
            updateFunctionList();
        }

        function updateFunctionList() {
            const functionsListContainer = document.getElementById('functions-list');
            functionsListContainer.innerHTML = '';

            functions.forEach((func) => {
                const functionItem = document.createElement('div');
                functionItem.className = 'function-item input-group mb-2';
                functionItem.innerHTML = `
                    <span class="form-control">${func.name}</span>
                    <button onclick="removeFunction(this, '${func.id}')" class="btn btn-outline-danger" type="button">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                functionsListContainer.appendChild(functionItem);
            });
        }

        function removeFunction(button, functionId) {
            const functionItem = button.closest('.function-item');
            const index = functions.findIndex(func => func.id === functionId);
            if (index !== -1) {
                functions.splice(index, 1);
                selectedFunctions.delete(functionId);
                functionItem.remove();
            }
        }

        function createWeeks() {
            const weekCountInput = document.getElementById('weeks');
            const weekCount = parseInt(weekCountInput.value);

            if (!weekCount || weekCount < 1) {
                alert("Por favor, insira um número válido de semanas.");
                return;
            }

            const weeksContainer = document.getElementById('weeks-container');
            weeksContainer.innerHTML = '';

            const selectedUsers = $('#users').val();
            const userNames = {};

            $('#users option:selected').each(function() {
                userNames[$(this).val()] = $(this).data('name');
            });

            for (let i = 1; i <= weekCount; i++) {
                const newWeek = document.createElement('div');
                newWeek.className = 'week mb-4';
                newWeek.id = `week-${i}`;
                newWeek.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>Semana ${i}</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        ${['domingo', 'segunda-feira', 'terça-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sábado'].map(day => `
                                                <div class="col-md-4 mb-3">
                                                    <h4 class="text-center">${day.charAt(0).toUpperCase() + day.slice(1)}</h4>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Função</th>
                                                                <th>Responsável</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            ${functions.map(func => `
                                                            <tr>
                                                                <td>
                                                                    <label for="responsible-${i}-${func.id}" class="form-label">${func.name}</label>
                                                                </td>
                                                                <td>
                                                                    <select id="responsible-${i}-${func.id}" class="form-control mb-2">
                                                                        <option value="">Selecione um responsável</option>
                                                                        ${selectedUsers.map(userId => `
                                                                                <option value="${userId}">${userNames[userId]}</option>
                                                                            `).join('')}
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        `).join('')}
                                                        </tbody>
                                                    </table>
                                                </div>
                                            `).join('')}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                weeksContainer.appendChild(newWeek);
            }
        }
    </script>
@stop
