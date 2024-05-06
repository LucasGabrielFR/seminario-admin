@extends('adminlte::page')

@section('title', 'Empréstimos')

@section('content_header')
    <h1>Esmprestimos</h1>
    <a href="{{ route('loan.create') }}" class="btn btn-dark">Novo Empréstimo</a>
@stop

@section('content')
    @php
        $heads = ['Nome do Livro', 'Autor', 'Editora', 'Usuário', 'Data de Emprestimo', 'Data para Devolução', 'Status', 'Ações'];

        $config = [
            'data' => $loans,
            'order' => [[7, 'desc']],
            'columns' => [null, null, null, null, null, null, null, ['orderable' => false]],
        ];
    @endphp
    <div class="card">
        <div class="card-body">
            <x-adminlte-datatable id="table1" :heads="$heads">
                @foreach ($config['data'] as $loan)
                    <tr>
                        <td>{{ $loan->book->name }}</td>
                        <td>{{ $loan->book->author }}</td>
                        <td>{{ $loan->book->publisher }}</td>
                        <td>{{ $loan->user->name }}</td>
                        <td>{{ date('d/m/Y H:i:s', strtotime($loan->date_loan)) }}</td>
                        <td>
                            @if ($loan->status == 1)
                                {{ date('d/m/Y', strtotime($loan->date_limit)) }}
                            @endif
                        </td>
                        <td>
                            @php
                                if (date('Y-m-d') > $loan->date_limit && $loan->status != 2) {
                                    echo '<span class="badge badge-danger">Atrasado</span>';
                                } elseif ($loan->status == 1) {
                                    echo '<span class="badge badge-success">Emprestado</span>';
                                } elseif ($loan->status == 2) {
                                    echo '<span class="badge badge-primary">Devolvido</span>';
                                }
                            @endphp
                        </td>
                        <td>
                            @if ($loan->status == 1)
                                <a class="btn btn-xs btn-default text-primary mx-1 shadow"
                                    href="{{ route('loan.return', $loan->id) }}">
                                    <i class="fa fa-lg fa-fw fas fa-bookmark" title="Devolver Livro"></i>
                                </a>
                                <a class="btn btn-xs btn-default text-primary mx-1 shadow"
                                    href="{{ route('loan.extendMin', $loan->id) }}">
                                    <i class="fa fa-lg fa-fw fa-calendar-week" title="Prorrogar 7 dias"></i>
                                </a>
                                <a class="btn btn-xs btn-default text-primary mx-1 shadow"
                                    href="{{ route('loan.extendMax', $loan->id) }}">
                                    <i class="fa fa-lg fa-fw fa-calendar-plus" title="Prorrogar 15 dias"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
@stop
