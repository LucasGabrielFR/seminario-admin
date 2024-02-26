@extends('adminlte::page')

@section('title', 'Editar categoria')

@section('content_header')
    <h1>Editar Categoria</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('category.update', $category->id) }}" class="form" method="POST">
                @csrf
                @method('PUT')
                @include('admin.categories._partials.form')
            </form>
        </div>
    </div>
    <x-footer />
@stop
