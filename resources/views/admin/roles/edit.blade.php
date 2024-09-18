@extends('adminlte::page')

@section('title', 'Editar Cargo')

@section('content_header')
    <h1>Editar Cargo</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('role.update', $role->id) }}" class="form" method="POST">
                @csrf
                @method('PUT')
                @include('admin.roles._partials.form')
            </form>
        </div>
    </div>
    <x-footer />
@stop
