@extends('layouts.app')
@section('content')
<div class="content">

    <h1 class="page-title">
        {{$persona->nombre_completo}} - <small>Información de la víctima</small>
        <div class="pull-right">

            <a href="{{ action('entrevista_individualController@fichas_show',$persona->id_e_ind_fvt) }}?volver=0" class="btn bg-purple" data-toggle="tooltip" title="Ver línea de tiempo">
                {{ $persona->fmt_id_e_ind_fvt }}
            </a>



            {{-- <a href="{!! route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]) !!}" class="btn btn-default pull-right">Volver</a> --}}
            @if (isset($id_hecho) && isset($edicion))
                <a href="{!! route('victimas.volver')."?id_hecho=$id_hecho"."&edicion=$edicion" !!}" class="btn btn-default">Volver</a>
            @elseif(isset($id_hecho))
                <a href="{!! route('victimas.volver')."?id_hecho=$id_hecho" !!}" class="btn btn-default">Volver</a>
            @elseif (isset($ficha_show) && $ficha_show==1)
                <a  href="{!! route('entrevistaindividual.fichas_show', [$persona->id_e_ind_fvt]) !!}" class="btn btn-default">Volver</a>
            @elseif(isset($search) && $search)
                {{--<a href="{!! route('buscar_victimas') !!}" class="btn btn-default">Volver</a>--}}
            @else
                <a href="{!! route('victimas.volver')."?id_e_ind_fvt=$persona->id_e_ind_fvt" !!}" class="btn btn-default">Volver</a>
            @endif                                
            
        </div>            
        </h1>

    {{-- Datos de la victima para un hecho especifico --}}

    @php($id_persona=$persona->id_persona)

    @php($id_hecho = isset($id_hecho) ? $id_hecho : 0)

    @if($id_hecho>0)

        <div class='col-sm-12'>
            @include('hechos.hecho_victima')
        </div>
    @else
        @if(count($persona->listado_hechos())==0)
            <div class="box box-warning box-solid">
                <div class="box-header">
                    <h3 class="box-title">
                        <i class="fa fa-bolt"></i> Información de los hechos.
                    </h3>
                </div>
                <div class="box-body">
                    <div class="text-yellow text-center">
                        <h4><i class="icon fa fa-warning"></i> Atención</h4>
                        No se ha completado la información de los hechos
                    </div>
                </div>
            </div>
        @else
            @foreach($persona->listado_hechos() as $id_hecho)
                <div class='col-sm-12'>
                    @include('hechos.hecho_victima')
                </div>
            @endforeach
        @endif
    @endif
    <div class="clearfix"></div>

    {{-- Ficha personal --}}

    <div class="box box-primary box-solid">
        <div class="box-header">
            <h1 class="box-title">
                    Código de entrevista: {{$persona->fmt_id_e_ind_fvt}} 
            </h1>
        </div>

    
        <div class="box-body" style="padding-left:4%">
            <div class="row">
            {{--
           <div class="form-group col-sm-6"><h4><b>{{$persona->nombre_completo}}</b> - {{$persona->documento_identidad}}</h4></div>

               <div class="form-group col-sm-1 " style="margin-top: 10px;">
               <a href="{!! route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]) !!}" class="btn btn-default">Volver</a>
               </div>     --}}
                    <!-- Es Testigo Field -->
                @include('victimas.show_fields')
                <div class="form-group col-sm-12 ">
                
                {{-- <a href="{!! route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]) !!}" class="btn btn-default">Volver</a> --}}

                    @if (isset($id_hecho) && isset($edicion))
                        <a href="{!! route('victimas.volver')."?id_hecho=$id_hecho"."&edicion=$edicion" !!}" class="btn btn-default">Volver</a>
                    @elseif(isset($id_hecho))
                        <a href="{!! route('victimas.volver')."?id_hecho=$id_hecho" !!}" class="btn btn-default">Volver</a>
                    @elseif (isset($ficha_show) && $ficha_show==1)
                        <a  href="{!! route('entrevistaindividual.fichas_show', [$persona->id_e_ind_fvt]) !!}" class="btn btn-default">Volver</a>
                    @elseif(isset($search) && $search)
                        {{-- <a href="{!! route('buscar_victimas') !!}" class="btn btn-default">Volver</a>--}}
                    @else
                        <a href="{!! route('victimas.volver')."?id_e_ind_fvt=$persona->id_e_ind_fvt" !!}" class="btn btn-default">Volver</a>
                    @endif                                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection