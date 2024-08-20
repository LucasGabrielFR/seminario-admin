@extends('adminlte::page')

@section('title', 'Acervo Digital')

@section('content_header')
    <h1>Biblioteca Digital</h1>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" />
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <iframe src="https://drive.google.com/embeddedfolderview?id=1_etyyFdk_H3i3wSXzKtklhOa5yvRs0qn#grid" style="width:100%; height:600px; border:0;"></iframe>
                </div>
                <div class="card-footer">
                    <a class="btn btn-dark" href="https://drive.google.com/drive/folders/1_etyyFdk_H3i3wSXzKtklhOa5yvRs0qn?usp=sharing">
                        <i class="fa fa-lg fa-fw fa-folder-open"></i>Ver Pasta
                    </a>
                </div>
            </div>
        </div>
    </div>

@stop
@section('js')

@stop
