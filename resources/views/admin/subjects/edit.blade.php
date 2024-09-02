@extends('adminlte::page')

@section('title', 'Editar Disciplina')

@section('content_header')
    <h1>Editar Disciplina</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('subject.update', $subject->id) }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.subjects._partials.form')
            </form>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        function checkCode() {
            var code = document.getElementById('code').value;
            console.log(code);

            $.ajax({
                url: "{{ route('subject.check-code', '') }}/" + encodeURIComponent(code),
                type: 'GET',
                success: function(result) {
                    if (result) {
                        // Remove o atributo hidden da label com id "code-error"
                        document.getElementById('code-error').removeAttribute('hidden');
                        document.getElementById('submit').disabled = true;
                    } else {
                        // Opcional: Adicione lógica para ocultar a label se o código não existir
                        document.getElementById('code-error').setAttribute('hidden', true);
                        document.getElementById('submit').disabled = false;
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Erro na requisição AJAX:", error);
                }
            });
        }
    </script>
@stop
