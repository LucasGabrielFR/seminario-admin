@extends('adminlte::page')

@section('title', 'Cadastrar Novo Cargo')

@section('content_header')
    <h1>Cadastro de Cargo</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('role.store') }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.roles._partials.form')
            </form>
        </div>
    </div>
@stop
