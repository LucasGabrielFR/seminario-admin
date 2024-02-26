@extends('adminlte::page')

@section('title', 'Biblioteca')

@section('content_header')
    <h1>Biblioteca</h1>
    <a href="{{ route('book.create') }}" class="btn btn-dark">Novo Livro</a>
@stop

@section('content')
    @php
        $heads = ['Nome do Livro', 'Autor', 'Editora','Qtd.', 'Categorias', 'Ações'];

        $config = [
            'data' => $books,
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, null, ['orderable' => false]],
        ];
    @endphp
    <div class="card">
        <div class="card-body">
            <x-adminlte-datatable id="table1" :heads="$heads">
                @foreach ($config['data'] as $book)
                    <tr>
                        <td>{{ $book->name }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->publisher }}</td>
                        <td>{{ $book->qtd }}</td>
                        <td>
                            @foreach ($book->categories as $category)
                                <span class="badge badge-primary">{{ $category->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a class="btn btn-xs btn-default text-primary mx-1 shadow"
                                href="{{ route('book.edit', $book->id) }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <x-modal url="{{ route('book.delete', $book->id) }}" id="{{ $book->id }}"
                                name="{{ $book->name }}" />
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
@stop
