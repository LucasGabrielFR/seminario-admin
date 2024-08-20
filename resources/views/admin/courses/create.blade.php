@extends('adminlte::page')

@section('title', 'Cadastrar Novo Curso')

@section('content_header')
    <h1>Cadastro de Curso</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('course.store') }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.courses._partials.form')
            </form>
        </div>
    </div>
@stop
