@extends('adminlte::page')

@section('title', 'Cadastrar Novo Livro')

@section('content_header')
    <h1>Cadastro de Livro</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('book.store') }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.books._partials.form')
            </form>
        </div>
    </div>
@stop
