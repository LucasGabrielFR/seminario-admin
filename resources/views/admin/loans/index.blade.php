@extends('adminlte::page')

@section('title', 'Empréstimos')

@section('content_header')
    <h1>Empréstimos</h1>
    <a href="{{ route('loan.create') }}" class="btn btn-dark">Novo Empréstimo</a>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
@stop

@section('content')
    @php
        $heads = [
            'Nome do Livro',
            'Autor',
            'Editora',
            'Usuário',
            'Data de Empréstimo',
            'Data para Devolução',
            'Status',
            'Ações',
        ];

        $config = [
            'data' => $loans,
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, null, null, null, null, ['orderable' => false]],
        ];
    @endphp
    <div class="card">
        <div class="card-body">
            <x-adminlte-datatable id="table1" :heads="$heads">
                @foreach ($config['data'] as $loan)
                    <tr data-id="{{ $loan->id }}">
                        <td>{{ $loan->book->name }}</td>
                        <td>{{ $loan->book->author }}</td>
                        <td>{{ $loan->book->publisher }}</td>
                        <td>{{ $loan->user->name }}</td>
                        <td>{{ isset($loan->date_loan) ? date('d/m/Y H:i:s', strtotime($loan->date_loan)) : '' }}</td>
                        <td class="date-limit">{{ $loan->status == 1 ? date('d/m/Y', strtotime($loan->date_limit)) : '' }}</td>
                        <td>
                            @if (date('Y-m-d') > $loan->date_limit && $loan->status != 2)
                                <span class="badge badge-danger">Atrasado</span>
                            @elseif ($loan->status == 1)
                                <span class="badge badge-success">Emprestado</span>
                            @elseif ($loan->status == 2)
                                <span class="badge badge-primary">Devolvido</span>
                            @endif
                        </td>
                        <td>
                            @if ($loan->status == 1) <!-- Mostra os botões apenas se o status for "Emprestado" -->
                                <a class="btn btn-xs btn-default text-primary mx-1 shadow update-status" href="{{ route('loan.return', $loan->id) }}" data-action="return">
                                    <i class="fa fa-lg fa-fw fas fa-bookmark" title="Devolver Livro"></i>
                                </a>
                                <a class="btn btn-xs btn-default text-primary mx-1 shadow update-status" href="{{ route('loan.extendMin', $loan->id) }}" data-action="extendMin">
                                    <i class="fa fa-lg fa-fw fa-calendar-week" title="Prorrogar 7 dias"></i>
                                </a>
                                <a class="btn btn-xs btn-default text-primary mx-1 shadow update-status" href="{{ route('loan.extendMax', $loan->id) }}" data-action="extendMax">
                                    <i class="fa fa-lg fa-fw fa-calendar-plus" title="Prorrogar 15 dias"></i>
                                </a>
                            @endif
                            <!-- Não exibe nada se o status for "Devolvido" -->
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#table1').DataTable();
            table.order([6, 'desc']).draw();

            $('.update-status').click(function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var action = $(this).data('action');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        toastr.success(data.message);
                        var loanId = data.loan.id;
                        var newDateLimit = data.loan.date_limit; // A nova data de devolução
                        var loanStatus = data.loan.status; // O novo status do empréstimo

                        // Atualiza a célula da data para devolução
                        var dateLimitCell = $('tr[data-id="' + loanId + '"] td.date-limit');
                        dateLimitCell.text(newDateLimit);

                        // Atualiza o status na tabela
                        var statusCell = $('tr[data-id="' + loanId + '"] td').eq(6);
                        if (loanStatus == 2) {
                            statusCell.html('<span class="badge badge-primary">Devolvido</span>');

                            // Esconde os botões de ação ao devolver
                            $('tr[data-id="' + loanId + '"] td:last-child').html(''); // Limpa os botões de ação
                        } else {
                            statusCell.html('<span class="badge badge-success">Emprestado</span>');
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Ocorreu um erro ao atualizar o empréstimo.');
                        console.log(error);
                    }
                });
            });
        });
    </script>
@stop
