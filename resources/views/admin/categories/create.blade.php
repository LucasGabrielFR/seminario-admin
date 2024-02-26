@extends('adminlte::page')

@section('title', 'Cadastrar Nova Categoria')

@section('content_header')
    <h1>Cadastro de Categoria</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('category.store') }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.categories._partials.form')
            </form>
        </div>
    </div>
@stop
