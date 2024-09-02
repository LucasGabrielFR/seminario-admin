@extends('adminlte::page')

@section('title', 'Cadastrar Nova Disciplina')

@section('content_header')
    <h1>Cadastro de Disciplina</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('subject.store') }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.subjects._partials.form')
            </form>
        </div>
    </div>
@stop
