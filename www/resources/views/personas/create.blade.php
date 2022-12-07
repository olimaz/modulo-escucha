@extends('layouts.app')
@section('content')
<section class="content-header">
    <h1 class="page-header">
        Nuevo: Datos de la persona entrevistada - {{$persona->fmt_id_e_ind_fvt}}         
        <div class="pull-right">
            <a href="{!! route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]) !!}" class="btn btn-default pull-right">Volver</a>
        </div>                  
    </h1>     
</section>
<div class="content">
    <div class="box box-primary ">
            
        <div class="box-body" style="padding-left:4%; width: 98%"> 
            <div class="row">

                {!! Form::open(['route' => 'personas.store', 'name'=>'persona_entrevistada', 'id'=>'persona_entrevistada']) !!}

                    <input type="hidden" id="id_e_ind_fvt" name="id_e_ind_fvt" value="{{$persona->id_e_ind_fvt}}">
                    <input type="hidden" id="pendiente_entrevista" name="pendiente_entrevista" value="{{$pendiente_entrevista}}">
                    
                    @include('personas.fields')

                {!! Form::close() !!}
                
            </div>
        </div>
    </div>
</div>
@endsection