@extends('adminlte::page')

@section('title', 'Editar Livro')

@section('content_header')
    <h1>Editar Livro</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('book.update', $book->id) }}" class="form" method="POST">
                @csrf
                @method('PUT')
                @include('admin.books._partials.form')
            </form>
        </div>
    </div>
    <x-footer />
@stop
