@extends('layouts.app')
@section('content')
<section class="content-header">
        <h1 class="page-header">
            Nuevo: Datos de la víctima - {{$persona->fmt_id_e_ind_fvt}} 
            <div class="pull-right">
                {{-- <a href="{!! route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]) !!}" class="btn btn-default pull-right">Volver</a>--}}

                @if(isset($id_hecho) && isset($view_create))
                    <a href="{!! route('victimas.volver')."?id_hecho=$id_hecho"."&edicion=$edicion"."&view_create=$view_create" !!}" class="btn btn-default">Volver</a>
        
                @elseif (isset($id_hecho) && isset($edicion))
                    <a href="{!! route('victimas.volver')."?id_hecho=$id_hecho"."&edicion=$edicion" !!}" class="btn btn-default">Volver</a>
                
                @elseif(isset($id_hecho))
                    <a href="{!! route('victimas.volver')."?id_hecho=$id_hecho" !!}" class="btn btn-default">Volver</a>
                @else
                    <a href="{!! route('victimas.volver')."?id_e_ind_fvt=$persona->id_e_ind_fvt" !!}" class="btn btn-default">Volver</a>
                @endif                   
            </div>                
        </h1>
    </section>
<div class="content">
        <div class="box box-primary ">    
        <div class="box-body" style="padding-left:4%; width: 98%">
            <div class="row">

                <div id="s_errors"></div>                
                {!! Form::open(['route' => 'victimas.store']) !!}

                    <input type="hidden" id="id_e_ind_fvt" name="id_e_ind_fvt" value="{{$id_e_ind_fvt}}">

                    @if (isset($id_hecho) && $id_hecho>0)
                        <input type="hidden" id="view_create" name="view_create" value="1">
                    @endif
                    
                    @include('victimas.fields')

                {!! Form::close() !!}
                
            </div>
        </div>
    </div>
</div>
@endsection