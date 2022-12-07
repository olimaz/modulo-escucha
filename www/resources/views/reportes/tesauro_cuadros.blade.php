
@extends('layouts.app')
@section('content_header')
    <h1 class="page-header">Aplicación del árbol de etiquetas</h1>

@endsection


@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Comparación del uso del árbol de etiquetas</h3>
        </div>
        <div class="box-body text-center">
            @include("reportes.js_tesauro_circulos")
        </div>
    </div>




@endsection

@push("head")

@endpush
