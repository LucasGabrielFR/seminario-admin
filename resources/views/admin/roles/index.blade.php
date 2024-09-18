@extends('adminlte::page')

@section('title', 'Cargos')

@section('content_header')
    <h1>Cargos</h1>
    <a href="{{ route('role.create') }}" class="btn btn-dark">Novo Cargo</a>
@stop

@section('content')
    @php
        $heads = ['ID', 'Cargo', 'Ações'];

        $config = [
            'data' => $roles,
            'order' => [[1, 'asc']],
            'columns' => [null, ['orderable' => false]],
        ];
    @endphp
    <div class="card">
        <div class="card-body">
            <x-adminlte-datatable id="table1" :heads="$heads">
                @foreach ($config['data'] as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            <a class="btn btn-xs btn-default text-primary mx-1 shadow"
                                href="{{ route('role.edit', $role->id) }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            {{-- <x-modal url="{{ route('role.delete', $role->id) }}" id="{{ $role->id }}"
                                name="{{ $role->name }}" /> --}}
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
@stop
