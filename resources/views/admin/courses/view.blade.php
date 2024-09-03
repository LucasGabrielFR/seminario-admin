@extends('adminlte::page')

@section('plugins.Select2', true)

@section('title', 'Ver curso')

@section('content_header')
    <h1>Ver Curso</h1>
@stop

@section('content')
    @php
        $config = [
            'placeholder' => 'Select multiple options...',
            'allowClear' => true,
        ];
    @endphp
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Nome do Curso: </label>
                                {{ $course->name }}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="code">Código de Curso: </label>
                                {{ $course->code }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Abas -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="subjects-tab" data-toggle="tab" href="#subjects" role="tab"
                        aria-controls="subjects" aria-selected="true">Disciplinas</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="students-tab" data-toggle="tab" href="#students" role="tab"
                        aria-controls="students" aria-selected="false">Alunos Matriculados</a>
                </li>
            </ul>

            <div class="tab-content mt-3" id="myTabContent">
                <!-- Aba de Disciplinas -->
                <div class="tab-pane fade show active" id="subjects" role="tabpanel" aria-labelledby="subjects-tab">
                    <a class="btn btn-primary mb-3" href="{{ route('subject.create', $course->id) }}">
                        <i class="fa fa-lg fa-fw fa-plus"></i> Adicionar Disciplina
                    </a>
                    <h3>Disciplinas do Curso</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome da Disciplina</th>
                                <th scope="col">Código da Disciplina</th>
                                <th scope="col">Créditos</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($course->subjects as $subject)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->code }}</td>
                                    <td>{{ $subject->credits }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-outline-primary mx-1 shadow"
                                            href="{{ route('subject.edit', $subject->id) }}">
                                            <i class="fa fa-lg fa-fw fa-pen"></i> Editar
                                        </a>
                                        <x-modal url="{{ route('subject.delete', $subject->id) }}" id="{{ $subject->id }}"
                                            name="{{ $subject->name }}" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Aba de Alunos Matriculados -->
                <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="students-tab">
                    <a class="btn btn-primary mb-3" onclick="$('#row-users').toggle()">
                        <i class="fa fa-lg fa-fw fa-plus"></i> Matricular Aluno
                    </a>
                    <div class="row" id="row-users" style="display: none">
                        <div class="col-md-5">
                            <x-adminlte-select2 id="users" name="users[]" label="Usuários" label-class="text-primary"
                                :config="$config" multiple>
                                <x-slot name="appendSlot">
                                    <button class="btn btn-outline-dark" type="button" onclick="enrollStudents()">
                                        <i class="fas fa-lg fa-plus text-info"></i> Cadastrar
                                    </button>
                                </x-slot>
                                @foreach ($users as $user)
                                    @if (isset($course->students) && !in_array($user->id, $course->students->pluck('id')->toArray()))
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }}</option>
                                    @endif
                                @endforeach
                            </x-adminlte-select2>
                        </div>
                    </div>
                    <h3>Alunos Matriculados no Curso</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome do Aluno</th>
                                <th scope="col">Email</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($course->students as $student)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>
                                        <x-modal
                                            url="{{ route('student.delete', ['courseId' => $course->id, 'studentId' => $student->id]) }}"
                                            id="{{ $student->id }}" name="{{ $student->name }}" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        window.enrollStudents = function() {
            var selectedUsers = $('#users').val();
            var courseId = "{{ $course->id }}";

            if (selectedUsers.length > 0) {
                $.ajax({
                    url: '{{ route('students.enroll') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Antifraude
                        users: selectedUsers,
                        course_id: courseId
                    },
                    success: function(data) {
                        // Tratar sucesso (exibir mensagem, etc.)
                        alert('Alunos matriculados com sucesso!');
                        location.reload();
                    },
                    error: function(xhr) {
                        // Tratar erro (exibir mensagem, etc.)
                        alert('Ocorreu um erro ao matricular os alunos. Tente novamente.');
                    }
                });
            } else {
                alert('Selecione pelo menos um aluno para matricular.');
            }
        };
    });
</script>
