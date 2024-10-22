@extends('adminlte::page')

@section('title', 'Funções para Escala')

@section('content_header')
    <h1>Funções</h1>
    <a href="{{ route('scale-function.create') }}" class="btn btn-dark">Nova Função</a>
@stop

@section('content')
    @php
        $heads = ['Função', 'Ações'];

        $config = [
            'data' => $functions,
            'order' => [[1, 'asc']],
            'columns' => [null, ['orderable' => false]],
        ];
    @endphp
    <div class="card">
        <div class="card-body">
            <x-adminlte-datatable id="table1" :heads="$heads">
                @foreach ($config['data'] as $function)
                    <tr>
                        <td>{{ $function->name }}</td>
                        <td>
                            <a class="btn btn-xs btn-default text-primary mx-1 shadow"
                                href="{{ route('scale-function.edit', $function->id) }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <x-modal url="{{ route('scale-function.delete', $function->id) }}" id="{{ $function->id }}"
                                name="{{ $function->name }}" />
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
@stop
