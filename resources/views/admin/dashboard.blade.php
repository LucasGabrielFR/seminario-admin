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
        <div class="col-4">
            <x-adminlte-small-box title="Seminaristas" text="{{ $countSeminaristas }}" icon="fas fa-user text-white"
                theme="teal" url="{{ route('users') }}" />
        </div>
        <div class="col-4">
            <x-adminlte-small-box title="Livros" text="{{ $countBooks }}" icon="fas fa-book  text-white" theme="info"
                url="{{ route('library') }}" />
        </div>
        <div class="col-4">
            <x-adminlte-small-box title="Empréstimos" text="{{ $countLoans }}" icon="fas fa-address-card text-white"
                theme="dark" url="{{ route('loans') }}" />
        </div>
    </div>
@stop
@section('js')

@stop
