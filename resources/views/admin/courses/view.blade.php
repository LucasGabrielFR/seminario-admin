@extends('adminlte::page')

@section('title', 'Ver curso')

@section('content_header')
    <h1>Ver Curso</h1>
@stop

@section('content')
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
            <div class="row mt-4">
                <div class="col-md-12">
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
            </div>
        </div>
    </div>
@stop
