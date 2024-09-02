<input type="hidden" name="course_id" value="{{ $courseId}}">
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name">Nome da Disciplina<small>*</small></label>
                    <input type="text" class="form-control" name="name" id="name"
                        value="{{ $subject->name ?? '' }}" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="code">Código de Curso<small>*</small></label>
                    <input type="text" class="form-control" name="code" id="code"
                        value="{{ $subject->code ?? '' }}" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="credits">Créditos<small>*</small></label>
                    <input type="number" class="form-control" name="credits" id="credits"
                        value="{{ $subject->credits ?? '' }}" required>
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
