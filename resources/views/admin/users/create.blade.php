@extends('adminlte::page')

@section('title', 'Cadastrar Novo Seminarista')

@section('content_header')
    <h1>Cadastro de Seminarista</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('user.store') }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.users._partials.form')
            </form>
        </div>
    </div>
@stop
