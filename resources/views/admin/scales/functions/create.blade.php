@extends('adminlte::page')

@section('title', 'Cadastrar Nova Função')

@section('content_header')
    <h1>Cadastro de Função</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('scale-function.store') }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.scales.functions._partials.form')
            </form>
        </div>
    </div>
@stop
