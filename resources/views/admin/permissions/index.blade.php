@extends('adminlte::page')

@section('title', 'Permissões')

@section('content_header')
    <h1>Permissões</h1>
    <a href="{{ route('permission.create') }}" class="btn btn-dark">Nova Permissão</a>
@stop

@section('content')
    @php
        $heads = ['ID', 'Permissão', 'Ações'];

        $config = [
            'data' => $permissions,
            'order' => [[1, 'asc']],
            'columns' => [null, ['orderable' => false]],
        ];
    @endphp
    <div class="card">
        <div class="card-body">
            <x-adminlte-datatable id="table1" :heads="$heads">
                @foreach ($config['data'] as $permission)
                    <tr>
                        <td>{{ $permission->id }}</td>
                        <td>{{ $permission->name }}</td>
                        <td>
                            <a class="btn btn-xs btn-default text-primary mx-1 shadow"
                                href="{{ route('permission.edit', $permission->id) }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <x-modal url="{{ route('permission.delete', $permission->id) }}" id="{{ $permission->id }}"
                                name="{{ $permission->name }}" />
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
@stop
