@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
    <h1>Categorias</h1>
    <a href="{{ route('category.create') }}" class="btn btn-dark">Nova Categoria</a>
@stop

@section('content')
    @php
        $heads = ['Categoria', 'Ações'];

        $config = [
            'data' => $categories,
            'order' => [[1, 'asc']],
            'columns' => [null, ['orderable' => false]],
        ];
    @endphp
    <div class="card">
        <div class="card-body">
            <x-adminlte-datatable id="table1" :heads="$heads">
                @foreach ($config['data'] as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                            <a class="btn btn-xs btn-default text-primary mx-1 shadow"
                                href="{{ route('category.edit', $category->id) }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <x-modal url="{{ route('category.delete', $category->id) }}" id="{{ $category->id }}"
                                name="{{ $category->name }}" />
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
@stop
