@extends('adminlte::page')

@section('title', 'Editar Cadastro de Seminarista')

@section('content_header')
    <h1>Cadastro de Seminarista</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('user.update', $user->id) }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.users._partials.form')
            </form>
        </div>
    </div>
@stop
