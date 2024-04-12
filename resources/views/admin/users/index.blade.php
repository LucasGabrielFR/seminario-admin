@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h1>Usuários</h1>
    <a href="{{ route('user.create') }}" class="btn btn-dark">Novo Usuário</a>
@stop

@section('content')
    @php
        $heads = ['Nome', 'Turma', 'Cidade','Dt. Nascimento', 'Ações'];

        $config = [
            'data' => $users,
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, null, ['orderable' => false]],
        ];
    @endphp
    <div class="card">
        <div class="card-body">
            <x-adminlte-datatable id="table1" :heads="$heads">
                @foreach ($config['data'] as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->class }}</td>
                        <td>{{ $user->city }}</td>
                        <td>{{ $user->date_birthday }}</td>
                        <td>
                            <a class="btn btn-xs btn-default text-primary mx-1 shadow"
                                href="{{ route('user.edit', $user->id) }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <x-modal url="{{ route('user.delete', $user->id) }}" id="{{ $user->id }}"
                                name="{{ $user->name }}" />
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
@stop
