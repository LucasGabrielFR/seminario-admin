@extends('adminlte::page')

@section('title', 'Novo Empréstimo')

@section('content_header')
    <h1>Empréstimo</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('loan.store') }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.loans._partials.form')
            </form>
        </div>
    </div>
@stop
