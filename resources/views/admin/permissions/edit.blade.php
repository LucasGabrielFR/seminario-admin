@extends('adminlte::page')

@section('title', 'Editar Permissão')

@section('content_header')
    <h1>Editar Permissão</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('permission.update', $permission->id) }}" class="form" method="POST">
                @csrf
                @method('PUT')
                @include('admin.permissions._partials.form')
            </form>
        </div>
    </div>
    <x-footer />
@stop
