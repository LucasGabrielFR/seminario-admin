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
        <hr>
        @if ($loggedUser->permissions->contains('id', 1))
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                </div>
            </div>
            <hr>
        <div class="row">
            <div class="col-md-12">
                <label for="permissions">Permissões</label>
                <select class="form-select" id="multiple-select-optgroup-field" data-placeholder="Escolha as Permissões"
                    multiple name="permissions[]">
                    @foreach ($permissions as $permission)
                        <option value="{{ $permission->id }}" @if (isset($user->permissions) && in_array($permission->id, $user->permissions->pluck('id')->toArray())) selected @endif>
                            {{ $permission->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <hr>
        @endif
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
    </script>

@stop
