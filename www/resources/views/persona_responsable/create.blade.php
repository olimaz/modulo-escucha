@extends('layouts.app')
@section('content')
<div class="content">
    <div class="box box-primary box-solid">
      <section class="content-header">
              <h1 class="page-header">
                  Nueva: PERSONA RESPONSABLE
                  <small class="text-primary">
                          Código entrevista: {{$entrevista->entrevista_codigo}}
                  </small>
              </h1>
          </section>


        <div class="box-body" style="padding-left:4%; width: 98%">
            <div class="row">

                {!! Form::open(['route' => 'persona_responsable.store']) !!}


                    {{-- <input type="hidden" id="id_e_ind_fvt" name="id_e_ind_fvt" value="{{$id_e_ind_fvt}}"> --}}
                    @if ($tipo_entrevista=='individual')
                        <input type="hidden" id="id_e_ind_fvt" name="id_e_ind_fvt" value="{{$id_entrevista}}">
                    @else
                        <input type="hidden" id="id_entrevista_etnica" name="id_entrevista_etnica" value="{{$id_entrevista}}">
                    @endif
                    

                    {{-- Si es individual o sujeto colectivo etnico --}}
                    <input type="hidden" id="tipo_entrevista" name="tipo_entrevista" value="{{$tipo_entrevista}}">         
                    
                    @if(!empty($id_hecho))
                    <input type="hidden" id="id_hecho" name="id_hecho" value="{{$id_hecho}}">
                    @endif
                    @include('persona_responsable.fields')

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
@endsection
