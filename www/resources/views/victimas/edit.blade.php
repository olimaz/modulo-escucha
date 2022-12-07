@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Modificar: Datos de la víctima - {!! $entrevistaIndividual->entrevista_codigo !!}
            <div class="pull-right">
                {{--<a href="{!! route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]) !!}" class="btn btn-default pull-right">Volver</a>--}}

                @if (isset($id_hecho) && isset($edicion))
                    <a href="{!! route('victimas.volver')."?id_hecho=$id_hecho"."&edicion=$edicion" !!}" class="btn btn-default">Volver</a>
                @elseif(isset($id_hecho))
                    <a href="{!! route('victimas.volver')."?id_hecho=$id_hecho" !!}" class="btn btn-default">Volver</a>
                @elseif(isset($search) && $search)
                    <a href="{!! route('buscar_victimas') !!}" class="btn btn-default">Volver</a>
                @else
                    <a href="{!! route('victimas.volver')."?id_e_ind_fvt=$persona->id_e_ind_fvt" !!}" class="btn btn-default">Volver</a>
                @endif                      
            </div>                
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($persona, ['route' => ['victimas.update', $persona->id_persona], 'method' => 'patch']) !!}    
                                           
                        @include('victimas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection