@extends('layouts.app3')

@section("content_header")
    <h1 class="page-header text-primary">En construcción</h1>
@endsection


@section('content')
        <div class="row">
            <div class="container text-xl">
                    <div class="card mb-3" >
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ url('snail.gif') }}" alt="Trabajando">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Elaborando el borrador</h5>
                                    <p class="card-text">Estamos corriendo para tener esta funcionalidad lista lo antes posible.</p>
                                    <p class="card-text"><small class="text-muted">¡Regresa pronto!</small></p>
                                </div>
                            </div>
                        </div>
                    </div>


            </div>
        </div>






@endsection