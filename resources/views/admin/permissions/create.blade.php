@extends('adminlte::page')

@section('title', 'Cadastrar Nova Permissão')

@section('content_header')
    <h1>Cadastro de Permissão</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('permission.store') }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.permissions._partials.form')
            </form>
        </div>
    </div>
@stop
