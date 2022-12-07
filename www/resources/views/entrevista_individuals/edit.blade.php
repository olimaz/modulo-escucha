@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Modificar: Entrevista Individual  <small>(#{!! $entrevistaIndividual->entrevista_correlativo !!}) {!! $entrevistaIndividual->entrevista_codigo !!}</small>
        </h1>
        @if($entrevistaIndividual->id_subserie == config('expedientes.vi'))
            <ol class="breadcrumb">
                <li class="active"> 1. <i class="fa fa-folder-open-o"></i> Metadatos</li>
                <li ><a href="{{ action('entrevista_individualController@gestionar_adjuntos',$entrevistaIndividual->id_e_ind_fvt) }}"> 2. Adjuntos</a></li>
                <li><a href="{{ action('entrevista_individualController@fichas',$entrevistaIndividual->id_e_ind_fvt) }}">3. Fichas</a></li>
            </ol>
        @endif
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       {!! Form::model($entrevistaIndividual, ['route' => ['entrevistaIndividuals.update', $entrevistaIndividual->id_e_ind_fvt], 'method' => 'patch']) !!}
            @include('entrevista_individuals.fields_concentimiento')

    <div id='ocultar_entrevista'>

       <div class="box box-primary">
           <div class="box-body">
               <div class="row">


                        @include('entrevista_individuals.fields')
                        @include('entrevista_individuals.fields_especs')
                        {{-- FRM de clasificacion --}}
                        @php
                            $nna = $entrevistaIndividual->clasifica_nna;
                            $res = $entrevistaIndividual->clasifica_res;
                            $sex = $entrevistaIndividual->clasifica_sex;
                            $r1 = $entrevistaIndividual->clasifica_r1;
                            $r2 = $entrevistaIndividual->clasifica_r2;
                        @endphp
                        @include('partials.clasificacion_r1')


                        <!-- Submit Field -->
                       <div class="form-group col-sm-12">
                           {!! Form::submit('Actualizar expediente', ['class' => 'btn btn-primary']) !!}
                           <a href="{!! action('entrevista_individualController@show',$entrevistaIndividual->id_e_ind_fvt) !!}" class="btn btn-default">Cancelar</a>
                       </div>

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
       </div>
   </div>
@endsection

@push("js")
    <script>
        $(function() {

            @if($entrevistaIndividual->clasifica_nna==1)
                $("#clasifica_nna_1").iCheck('check');
            @else
                $("#clasifica_nna_2").iCheck('check');
            @endif
            //
            @if($entrevistaIndividual->clasifica_sex==1)
                $("#clasifica_sex_1").iCheck('check');
            @else
                $("#clasifica_sex_2").iCheck('check');
            @endif
            //
            @if($entrevistaIndividual->clasifica_res==1)
                $("#clasifica_res_1").iCheck('check');
            @else
                $("#clasifica_res_2").iCheck('check');
            @endif
        });
    </script>
@endpush
