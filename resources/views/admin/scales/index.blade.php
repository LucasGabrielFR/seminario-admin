@extends('adminlte::page')

@section('title', 'Escalas')

@section('content_header')
    <h1>Escalas</h1>
    <a href="{{ route('scale.create') }}" class="btn btn-dark">Nova Escala</a>
@stop

@section('content')
    @php
        $heads = ['Escala', 'Semanas', 'Semana Atual', 'Ações'];

        $config = [
            'data' => $scales,
            'order' => [[1, 'asc']],
            'columns' => [null, ['orderable' => false]],
        ];
    @endphp
    <div class="card">
        <div class="card-body">
            <x-adminlte-datatable id="table1" :heads="$heads">
                @foreach ($config['data'] as $scale)
                    <tr>
                        <td>{{ $scale->name }}</td>
                        <td>{{ $scale->weeks }}</td>
                        <td>{{ $scale->current_week }}</td>
                        <td>
                            {{-- <a class="btn btn-xs btn-default text-primary mx-1 shadow"
                                href="{{ route('scale.edit', $scale->id) }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a> --}}
                            <x-modal url="{{ route('scale.delete', $scale->id) }}" id="{{ $scale->id }}"
                                name="{{ $scale->name }}" />
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
@stop
