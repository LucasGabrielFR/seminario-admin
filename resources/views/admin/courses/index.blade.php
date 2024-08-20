@extends('adminlte::page')

@section('title', 'Cursos')

@section('content_header')
    <h1>Cursos</h1>
    <a href="{{ route('course.create') }}" class="btn btn-dark">Novo Curso</a>
@stop

@section('content')
    @php
        $heads = ['Curso', 'Código', 'Ações'];

        $config = [
            'data' => $courses,
            'order' => [[1, 'asc']],
            'columns' => [null,null, ['orderable' => false]],
        ];
    @endphp
    <div class="card shadow-sm">
        <div class="card-body">
            <x-adminlte-datatable id="table1" :heads="$heads" class="table table-striped">
                @foreach ($config['data'] as $course)
                    <tr>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->code }}</td>
                        <td>
                            <a class="btn btn-xs btn-outline-primary mx-1 shadow"
                                href="{{ route('category.edit', $course->id) }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i> Editar
                            </a>
                            <a class="btn btn-xs btn-outline-info mx-1 shadow"
                                href="{{ route('category.edit', $course->id) }}">
                                <i class="fa fa-lg fa-fw fa-eye"></i> Ver
                            </a>
                            <x-modal url="{{ route('category.delete', $course->id) }}" id="{{ $course->id }}"
                                name="{{ $course->name }}" />
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
@stop
