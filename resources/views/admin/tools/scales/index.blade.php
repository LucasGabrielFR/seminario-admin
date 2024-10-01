@extends('adminlte::page')

@section('title', 'Gerador de Escalas')

@section('content_header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" />
@stop

@section('content')

    <body class="bg-light">
        <div class="container py-4">
            <h1 class="mb-4">Gerador de Escalas</h1>
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title">Funções</h3>
                    <div id="functions-list">
                        <div class="function-item input-group mb-2">

                        </div>
                    </div>
                    <button onclick="addFunction()" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-plus-circle"></i> Adicionar Função
                    </button>
                </div>
            </div>
            <div id="weeks-container">
                <div class="week mb-4" id="week-1">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>Semana 1</h2>
                        <button onclick="removeWeek(1)" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-trash"></i> Remover Semana
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <h4>Segunda-feira</h4>
                                            <div id="monday-1" class="responsible-container">
                                                <!-- Responsáveis serão adicionados aqui dinamicamente -->
                                            </div>
                                            <button onclick="addResponsible(1, 'monday')"
                                                class="btn btn-outline-primary btn-sm mt-2">
                                                <i class="fas fa-plus-circle"></i> Adicionar
                                            </button>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <h4>Terça-feira</h4>
                                            <div id="tuesday-1" class="responsible-container">
                                                <!-- Responsáveis serão adicionados aqui dinamicamente -->
                                            </div>
                                            <button onclick="addResponsible(1, 'tuesday')"
                                                class="btn btn-outline-primary btn-sm mt-2">
                                                <i class="fas fa-plus-circle"></i> Adicionar
                                            </button>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <h4>Quarta-feira</h4>
                                            <div id="wednesday-1" class="responsible-container">
                                                <!-- Responsáveis serão adicionados aqui dinamicamente -->
                                            </div>
                                            <button onclick="addResponsible(1, 'wednesday')"
                                                class="btn btn-outline-primary btn-sm mt-2">
                                                <i class="fas fa-plus-circle"></i> Adicionar
                                            </button>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <h4>Quinta-feira</h4>
                                            <div id="thursday-1" class="responsible-container">
                                                <!-- Responsáveis serão adicionados aqui dinamicamente -->
                                            </div>
                                            <button onclick="addResponsible(1, 'thursday')"
                                                class="btn btn-outline-primary btn-sm mt-2">
                                                <i class="fas fa-plus-circle"></i> Adicionar
                                            </button>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <h4>Sexta-feira</h4>
                                            <div id="friday-1" class="responsible-container">
                                                <!-- Responsáveis serão adicionados aqui dinamicamente -->
                                            </div>
                                            <button onclick="addResponsible(1, 'friday')"
                                                class="btn btn-outline-primary btn-sm mt-2">
                                                <i class="fas fa-plus-circle"></i> Adicionar
                                            </button>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <h4>Sábado</h4>
                                            <div id="saturday-1" class="responsible-container">
                                                <!-- Responsáveis serão adicionados aqui dinamicamente -->
                                            </div>
                                            <button onclick="addResponsible(1, 'saturday')"
                                                class="btn btn-outline-primary btn-sm mt-2">
                                                <i class="fas fa-plus-circle"></i> Adicionar
                                            </button>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <h4>Domingo</h4>
                                            <div id="sunday-1" class="responsible-container">
                                                <!-- Responsáveis serão adicionados aqui dinamicamente -->
                                            </div>
                                            <button onclick="addResponsible(1, 'sunday')"
                                                class="btn btn-outline-primary btn-sm mt-2">
                                                <i class="fas fa-plus-circle"></i> Adicionar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button onclick="addWeek()" class="btn btn-primary mt-3">
                Adicionar Semana
            </button>
        </div>
    @stop
    @section('js')
        <script>
            let weekCount = 1;
            let functions = [];

            function addFunction() {
                const functionsList = document.getElementById('functions-list');
                const newFunction = document.createElement('div');
                newFunction.className = 'function-item input-group mb-2';
                newFunction.innerHTML = `
                <input type="text" class="form-control" placeholder="Nome da Função">
                <button onclick="removeFunction(this)" class="btn btn-outline-danger" type="button">
                    <i class="fas fa-times"></i>
                </button>
            `;
                functionsList.appendChild(newFunction);
                functions.push(newFunction);
            }

            function removeFunction(button) {
                const functionItem = button.closest('.function-item');
                const index = Array.from(functionItem.parentNode.children).indexOf(functionItem);
                functions.splice(index, 1);
                functionItem.remove();
            }

            function addWeek() {
                weekCount++;
                const weekContainer = document.getElementById('weeks-container');
                const newWeek = document.createElement('div');
                newWeek.className = 'week mb-4';
                newWeek.id = `week-${weekCount}`;
                newWeek.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Semana ${weekCount}</h2>
                    <button onclick="removeWeek(${weekCount})" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-trash"></i> Remover Semana
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Dias da Semana</h3>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <h4>Segunda-feira</h4>
                                        <div id="monday-${weekCount}" class="responsible-container">
                                            <!-- Responsáveis serão adicionados aqui dinamicamente -->
                                        </div>
                                        <button onclick="addResponsible(${weekCount}, 'monday')" class="btn btn-outline-primary btn-sm mt-2">
                                            <i class="fas fa-plus-circle"></i> Adicionar
                                        </button>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <h4>Terça-feira</h4>
                                        <div id="tuesday-${weekCount}" class="responsible-container">
                                            <!-- Responsáveis serão adicionados aqui dinamicamente -->
                                        </div>
                                        <button onclick="addResponsible(${weekCount}, 'tuesday')" class="btn btn-outline-primary btn-sm mt-2">
                                            <i class="fas fa-plus-circle"></i> Adicionar
                                        </button>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <h4>Quarta-feira</h4>
                                        <div id="wednesday-${weekCount}" class="responsible-container">
                                            <!-- Responsáveis serão adicionados aqui dinamicamente -->
                                        </div>
                                        <button onclick="addResponsible(${weekCount}, 'wednesday')" class="btn btn-outline-primary btn-sm mt-2">
                                            <i class="fas fa-plus-circle"></i> Adicionar
                                        </button>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <h4>Quinta-feira</h4>
                                        <div id="thursday-${weekCount}" class="responsible-container">
                                            <!-- Responsáveis serão adicionados aqui dinamicamente -->
                                        </div>
                                        <button onclick="addResponsible(${weekCount}, 'thursday')" class="btn btn-outline-primary btn-sm mt-2">
                                            <i class="fas fa-plus-circle"></i> Adicionar
                                        </button>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <h4>Sexta-feira</h4>
                                        <div id="friday-${weekCount}" class="responsible-container">
                                            <!-- Responsáveis serão adicionados aqui dinamicamente -->
                                        </div>
                                        <button onclick="addResponsible(${weekCount}, 'friday')" class="btn btn-outline-primary btn-sm mt-2">
                                            <i class="fas fa-plus-circle"></i> Adicionar
                                        </button>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <h4>Sábado</h4>
                                        <div id="saturday-${weekCount}" class="responsible-container">
                                            <!-- Responsáveis serão adicionados aqui dinamicamente -->
                                        </div>
                                        <button onclick="addResponsible(${weekCount}, 'saturday')" class="btn btn-outline-primary btn-sm mt-2">
                                            <i class="fas fa-plus-circle"></i> Adicionar
                                        </button>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <h4>Domingo</h4>
                                        <div id="sunday-${weekCount}" class="responsible-container">
                                            <!-- Responsáveis serão adicionados aqui dinamicamente -->
                                        </div>
                                        <button onclick="addResponsible(${weekCount}, 'sunday')" class="btn btn-outline-primary btn-sm mt-2">
                                            <i class="fas fa-plus-circle"></i> Adicionar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                weekContainer.appendChild(newWeek);
            }

            function removeWeek(weekId) {
                const weekElement = document.getElementById(`week-${weekId}`);
                weekElement.remove();

                // Atualizar os números das semanas restantes
                const weekElements = document.querySelectorAll('.week');
                weekCount = 1;
                weekElements.forEach((week, index) => {
                    week.id = `week-${weekCount}`;
                    week.querySelector('h2').textContent = `Semana ${weekCount}`;
                    week.querySelectorAll('button[onclick]').forEach(button => {
                        button.setAttribute('onclick', `removeWeek(${weekCount})`);
                    });
                    weekCount++;
                });
            }

            function addResponsible(weekId, day) {
                const dayContainer = document.getElementById(`${day}-${weekId}`);
                const functionCount = functions.length;

                if (dayContainer.children.length < functionCount) {
                    const newResponsible = document.createElement('div');
                    newResponsible.className = 'responsible-item input-group mb-2';
                    newResponsible.innerHTML = `
                    <select class="form-select">
                        <option value="">Selecione um responsável</option>
                        <option value="responsavel1">Responsável 1</option>
                        <option value="responsavel2">Responsável 2</option>
                        <option value="responsavel3">Responsável 3</option>
                    </select>
                    <button onclick="removeResponsible(this)" class="btn btn-outline-danger" type="button">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                    dayContainer.appendChild(newResponsible);
                } else {
                    alert(`Você só pode adicionar até ${functionCount} responsáveis por dia.`);
                }
            }

            function removeResponsible(button) {
                button.closest('.responsible-item').remove();
            }
        </script>
    @stop
