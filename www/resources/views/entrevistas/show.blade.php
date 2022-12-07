@extends('layouts.app')

@section('content')

    <div class="content">
      @if(!empty($msg))
      <div class="alert alert-danger">{{$msg}}</div>
      @endif


          <section class="content-header">
                  <h1 class="page-header">
                      Ver: ESPECIFICACIONES de las Entrevista
                      <small class="text-primary">
                              Código entrevista: {{$entrevista->fmt_id_e_ind_fvt}}
                      </small>
                  </h1>
              </section>

      <div class="row" style="padding-left: 20px">

          <a href="{!! route('entrevistaindividual.fichas', [$entrevista->id_e_ind_fvt]) !!}" class="btn btn-default pull-right" style="margin-right:2%">Volver</a>

    </div>
        <!-- <div class="box box-primary box-solid">



            <div class="box-body">
                <div class="row" style="padding-left: 20px"> -->
                    @include('entrevistas.show_fields')

                      <!-- <a href="{!! route('entrevistaindividual.fichas', [$entrevista->id_e_ind_fvt]) !!}" class="btn btn-default">Volver</a> -->
                <!-- </div>
            </div>
        </div> -->
    </div>

@endsection
