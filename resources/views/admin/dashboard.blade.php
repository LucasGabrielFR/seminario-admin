@extends('adminlte::page')

@section('title', 'Seminário Diocesano São José')

@section('content_header')
    <h1>Dashboard</h1>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
@stop

@section('content')
    <div class="row">
        <div class="col-auto">
            <x-adminlte-small-box title="Usuários" text="{{ $countSeminaristas }}"
                theme="teal" url="{{ route('users') }}" />
        </div>
        <div class="col-auto">
            <x-adminlte-small-box title="Livros" text="{{ $countBooks }}" theme="info"
                url="{{ route('library') }}" />
        </div>
        <div class="col-auto">
            <x-adminlte-small-box title="Empréstimos" text="{{ $countLoans }}"
                theme="dark" url="{{ route('loans') }}" />
        </div>
    </div>
@stop
@section('js')

@stop
