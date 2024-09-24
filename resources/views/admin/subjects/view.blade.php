@extends('adminlte::page')

@section('plugins.Select2', true)

@section('title', 'Ver disciplina')

@section('content_header')
    <h1>Ver Disciplina</h1>
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
                                <label for="name">Nome da Disciplina: </label>
                                {{ $subject->name }}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="code">Código de Disciplina: </label>
                                {{ $subject->code }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="link">Link da Sala: </label>
                                {{ $subject->link }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Abas -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="students-tab" data-toggle="tab" href="#students" role="tab"
                        aria-controls="students" aria-selected="false">Alunos Matriculados</a>
                </li>
            </ul>

            <div class="tab-content mt-3" id="myTabContent">
                <!-- Aba de Alunos Matriculados -->
                <div class="tab-pane fade show active" id="students" role="tabpanel" aria-labelledby="students-tab">
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
                                @foreach ($subject->course->students as $user)
                                    @if (isset($subject->students) && !in_array($user->id, $subject->students->pluck('id')->toArray()))
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }}</option>
                                    @endif
                                @endforeach
                            </x-adminlte-select2>
                        </div>
                    </div>
                    <h3>Alunos Matriculados na Disciplina</h3>
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
                            @foreach ($subject->students as $student)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>
                                        <x-modal
                                            url="{{ route('student.subject.delete', ['subjectId' => $subject->id, 'studentId' => $student->id]) }}"
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
            var subjectId = "{{ $subject->id }}";

            if (selectedUsers.length > 0) {
                $.ajax({
                    url: '{{ route('students.subject.enroll') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Antifraude
                        users: selectedUsers,
                        subject_id: subjectId
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
