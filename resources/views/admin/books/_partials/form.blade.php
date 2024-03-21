<!-- Styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- Or for RTL support -->
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

<div class="row">
    <div class="col-md-auto">
        <div class="row">
            <div class="card">
                <div class="card-body" style="max-width: 33vh;">
                    <div class="p-3" id="img-container">
                        @if (isset($book->image))
                            <img src="{{ url("{$book->image}") }}" alt="" class="card-img-top"
                                id="image-preview">
                        @endif
                        @if (!isset($book->image))
                            <img src="{{ url('img/book.png') }}" alt="" class="card-img-top" id="image-preview">
                        @endif

                    </div>
                    <div class="mb-3 text-center">
                        <label for="formFile" class="form-label">Foto</label>
                        <input class="form-control" id="img-input" type="file" name="image" accept="image/*">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-auto">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Nome do Livro<small>*</small></label>
                    <input type="text" class="form-control" name="name" id="name"
                        value="{{ $book->name ?? '' }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="author">Autor<small>*</small></label>
                    <input type="text" class="form-control" name="author" id="author"
                        value="{{ $book->author ?? '' }}" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="publish">Ano de publicação<small>*</small></label>
                    <input type="number" min="1900" max="2100" class="form-control" name="publish"
                        id="publish" value="{{ $book->publish ?? '' }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="publisher">Editora<small>*</small></label>
                    <input type="text" class="form-control" name="publisher" id="publisher"
                        value="{{ $book->publisher ?? '' }}" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="edition">Edição<small>*</small></label>
                    <input type="text" class="form-control" name="edition" id="edition"
                        value="{{ $book->edition ?? '' }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" class="form-control" name="isbn" id="isbn" onchange="checkISBN(this.value)"
                        value="{{ $book->isbn ?? '' }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="page_num">Número de Páginas<small>*</small></label>
                    <input type="number" class="form-control" name="page_num" id="page_num"
                        value="{{ $book->page_num ?? '' }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="qtd">Quantidade disponível<small>*</small></label>
                    <input type="number" class="form-control" name="qtd" id="qtd"
                        value="{{ $book->qtd ?? '' }}" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="section">Seção</label>
                    <input type="text" class="form-control" name="section" id="section"
                        value="{{ $book->section ?? '' }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="bookshelf">Prateleira</label>
                    <input type="text" class="form-control" name="bookshelf" id="bookshelf"
                        value="{{ $book->bookshelf ?? '' }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="description">Descrição do livro (Sinopse)</label>
                    <textarea class="form-control" name="description" id="description" rows="5" cols="33">{{ $book->description ?? '' }}</textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="categories">Categorias</label>
                <select class="form-select" id="multiple-select-optgroup-field" data-placeholder="Escolha as categorias"
                    multiple name="categories[]">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if(isset($book->categories) && in_array($category->id, $book->categories->pluck('id')->toArray())) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-2">
                <button type="submit" class="btn btn-dark">Salvar</button>
            </div>
        </div>
    </div>
</div>
@section('js')
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script>
        $('#multiple-select-optgroup-field').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });
        function checkISBN(isbn) {
        // Construa a URL da API do Google Books com o ISBN fornecido
        let url = `https://www.googleapis.com/books/v1/volumes?q=isbn:${isbn}`;

        // Faça uma solicitação AJAX para a API do Google Books
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao buscar livro.');
                }
                return response.json();
            })
            .then(data => {
                // Manipule os dados recebidos, por exemplo, exiba-os no console
                var info = data.items[0].volumeInfo;
                var author = info.authors[0];
                var title = info.title;
                var pageNum = info.pageCount;
                var publisher = info.publisher;
                var publish = info.publishedDate;


                document.getElementById("author").value = author;
                document.getElementById("name").value = title;
                document.getElementById("page_num").value = pageNum;
                document.getElementById("publisher").value = publisher;
                document.getElementById("publish").value = publish;

            })
            .catch(error => {
                console.error('Erro:', error);
            });
    }

    </script>
@stop
