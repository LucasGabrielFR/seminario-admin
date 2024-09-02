@extends('adminlte::page')

@section('title', 'Editar curso')

@section('content_header')
    <h1>Editar Curso</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('course.update', $course->id) }}" class="form" method="POST">
                @csrf
                @method('PUT')
                @include('admin.courses._partials.form')
            </form>
        </div>
    </div>
    <x-footer />
@stop
