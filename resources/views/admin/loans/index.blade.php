@extends('adminlte::page')

@section('title', 'Empréstimos')

@section('content_header')
    <h1>Esmprestimos</h1>
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
            'Data de Emprestimo',
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
                        <td>{{ date('d/m/Y H:i:s', strtotime($loan->date_loan)) }}</td>
                        <td class="date-limit">
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
                                <a class="btn btn-xs btn-default text-primary mx-1 shadow update-status"
                                    href="{{ route('loan.return', $loan->id) }}">
                                    <i class="fa fa-lg fa-fw fas fa-bookmark" title="Devolver Livro"></i>
                                </a>
                                <a class="btn btn-xs btn-default text-primary mx-1 shadow update-status"
                                    href="{{ route('loan.extendMin', $loan->id) }}">
                                    <i class="fa fa-lg fa-fw fa-calendar-week" title="Prorrogar 7 dias"></i>
                                </a>
                                <a class="btn btn-xs btn-default text-primary mx-1 shadow update-status"
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
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#table1').DataTable();

            table.order([6, 'desc']).draw();
        });

        $(document).ready(function() {
            $('.update-status').click(function(e) {
                e.preventDefault();
                var url = $(this).attr('href');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        toastr.success(data.message);

                        // Atualize a interface do usuário com os novos dados recebidos
                        var loanId = data.loan.id;
                        var newDateLimit = data.loan.date_limit;

                        // Encontrar a célula da data para devolução correspondente ao empréstimo atualizado
                        var dateLimitCell = $('tr[data-id="' + loanId + '"] td.date-limit');

                        // Atualizar a data para devolução na célula correspondente
                        dateLimitCell.text(newDateLimit);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@stop
