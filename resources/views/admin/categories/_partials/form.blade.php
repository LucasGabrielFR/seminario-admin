<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name">Nome da Categoria<small>*</small></label>
                    <input type="text" class="form-control" name="name" id="name"
                        value="{{ $category->name ?? '' }}" required>
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
