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

                        @foreach ($books as $book)
                            <option value="{{ $book->id }}">{{ $book->name }}</option>
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
            $('#book_id').select2({
                theme: 'classic',
            });
            $('#user_id').select2({
                theme: 'classic',
            });

        });
    </script>
@stop
