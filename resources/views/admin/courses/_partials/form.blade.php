<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name">Nome do Curso<small>*</small></label>
                    <input type="text" class="form-control" name="name" id="name"
                        value="{{ $course->name ?? '' }}" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="code">Código de Curso<small>*</small></label>
                    <input type="text" class="form-control" name="code" id="code"
                        value="{{ $course->code ?? '' }}" required>
                </div>
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
