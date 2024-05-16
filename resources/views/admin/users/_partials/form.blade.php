<div class="row">
    <div class="col-md-auto">
        <div class="row">
            <div class="card">
                <div class="card-body" style="max-width: 33vh;">
                    <div class="p-3" id="img-container">
                        @if (isset($user->image))
                            <img src="{{ url("{$book->image}") }}" alt="" class="card-img-top"
                                id="image-preview">
                        @endif
                        @if (!isset($user->image))
                            <img src="{{ url('img/blank-profile.png') }}" alt="" class="card-img-top"
                                id="image-preview">
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
                    <label for="name">Nome do Usuário<small>*</small></label>
                    <input type="text" class="form-control" name="name" id="name"
                        value="{{ $user->name ?? '' }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="author">Email<small>*</small></label>
                    <input type="email" class="form-control" name="email" id="email"
                        value="{{ $user->email ?? '' }}" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Cidade<small>*</small></label>
                    <input type="text" class="form-control" name="city" id="city"
                        value="{{ $user->city ?? '' }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="author">Data de Nascimento<small>*</small></label>
                    <input type="date" class="form-control" name="date_birthday" id="date_birthday"
                        value="{{ $user->date_birthday ?? '' }}" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Contato<small>*</small></label>
                    <input type="text" class="form-control" name="phone" id="phone"
                        value="{{ $user->phone ?? '' }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="author">Turma<small>*</small></label>
                    <input type="text" class="form-control" name="class" id="class"
                        value="{{ $user->class ?? '' }}" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <button type="submit" class="btn btn-dark">Salvar</button>
            </div>
        </div>

    </div>
</div>
