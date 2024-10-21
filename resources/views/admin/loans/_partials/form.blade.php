<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="name">Nome do Usuário<small>*</small></label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">Selecione</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="name">Nome do Livro<small>*</small></label>
                    <select type="text" name="book_id" id="book_id" class="form-control" list="list-books"
                        required>
                        <option value="">Selecione</option>
                        @foreach ($books as $book)
                            <option value="{{ $book->id }}" data-pages="{{ $book->page_num }}">{{ $book->name }}
                            </option>
                        @endforeach
                    </select>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="name">Data para Devolução<small>*</small></label>
                    <input type="date" class="form-control" name="date_limit" id="date_limit" required>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-2">
        <button type="submit" class="btn btn-dark">Salvar</button>
    </div>
</div>
@section('js')
    <script>
        $(document).ready(function() {

            $('#book_id').change(function() {
                var selectedOption = $(this).find('option:selected');
                var pages = parseInt(selectedOption.data('pages')); // Obtém o número de páginas do livro
                var currentDate = new Date();
                var returnDate;

                // Calcula a data de devolução
                if (pages < 100) {
                    currentDate.setDate(currentDate.getDate() + 7); // 7 dias para devolução
                } else {
                    currentDate.setDate(currentDate.getDate() + 15); // 15 dias para devolução
                }

                // Formata a data para o formato YYYY-MM-DD
                returnDate = currentDate.toISOString().split('T')[0];
                $('#date_limit').val(returnDate); // Define a data de devolução no campo
            });
        });
    </script>
@stop
