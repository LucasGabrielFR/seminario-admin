@extends('adminlte::page')

@section('title', 'Editar Função')

@section('content_header')
    <h1>Editar Função</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('scale-function.update', $function->id) }}" class="form" method="POST">
                @csrf
                @method('PUT')
                @include('admin.scales.functions._partials.form')
            </form>
        </div>
    </div>
    <x-footer />
@stop
