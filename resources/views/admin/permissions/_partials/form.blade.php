<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="id">ID<small>*</small></label>
                    <input type="number" class="form-control" name="id" id="id"
                        value="{{ $permission->id ?? '' }}" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name">Nome da Permissão<small>*</small></label>
                    <input type="text" class="form-control" name="name" id="name"
                        value="{{ $permission->name ?? '' }}" required>
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
