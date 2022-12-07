

        <!-- Entrevista Fecha Field -->
        <div class="form-group col-sm-4">
            {!! Form::label('entrevista_fecha', 'Fecha de la entrevista:') !!}
            <p>
                {!! $entrevistaIndividual->fmt_entrevista_fecha !!}
                @if($entrevistaIndividual->tiempo_entrevista>0)
                    ({{ $entrevistaIndividual->tiempo_entrevista }} minutos)
                @endif
            </p>
        </div>

        <!-- Entrevista Lugar Field -->
        <div class="form-group  col-sm-4">
            <label>Lugar de la entrevista: {!!   $entrevistaIndividual->es_virtual == 1 ? "<span class='text-success'>-Medios virtuales-</span>" : "" !!}</label>
            <p>{!! $entrevistaIndividual->fmt_entrevista_lugar !!}</p>
        </div>





        <!-- Id Entrevistador Field -->
        {{--
        <div class="form-group  col-sm-6">
            {!! Form::label('id_entrevistador', 'Entrevistador:') !!}
            <p>
                {!! $entrevistaIndividual->fmt_id_entrevistador !!}
                @if($entrevistaIndividual->rel_id_entrevistador->id_grupo > 1)
                    ({{ $entrevistaIndividual->rel_id_entrevistador->fmt_id_grupo }})
                @endif
            </p>
        </div>
        --}}

        <!-- Id Macroterritorio Field -->
        <div class="form-group  col-sm-4">
            {!! Form::label('id_macroterritorio', 'Territorio (Macroterritorio):') !!}
            <p>{{ $entrevistaIndividual->fmt_id_territorio  }}  ({!! $entrevistaIndividual->fmt_id_macroterritorio !!}) </p>
        </div>
        <div class="clearfix"></div>


        <div class="form-group  col-sm-6">
            {!! Form::label('id_sector', 'Sector con el que se puede identificar a las víctmas en el relato:') !!}
            <p>{!! $entrevistaIndividual->fmt_id_sector !!}</p>
        </div>


        <div class="form-group  col-sm-6">
            {!! Form::label('id_etnico', 'Esta es una entrevista de interés étnico:') !!}
            <p>{!! $entrevistaIndividual->fmt_id_etnico !!}</p>
        </div>



        <hr>

        <div class="form-group  col-sm-12">
            {!! Form::label('titulo', 'Título:') !!}
            <p class="text-primary">{!! $entrevistaIndividual->titulo !!}</p>
        </div>



        <!-- Hechos Del Field -->
        <div class="form-group  col-sm-6">
            {!! Form::label('hechos_del', 'Fecha de los hechos:') !!}
            <p>{!! $entrevistaIndividual->fmt_fecha_hechos !!}</p>
        </div>


        <!-- Hechos Lugar Field -->
        <div class="form-group  col-sm-6">
            {!! Form::label('hechos_lugar', 'Lugar de los hechos:') !!}
            <p>{!! $entrevistaIndividual->fmt_hechos_lugar !!}</p>
        </div>

        @if($entrevistaIndividual->id_subserie == config('expedientes.vi'))


        <!-- Fuerzas responsables -->
        <div class="form-group  col-sm-6">
            {!! Form::label('fr', 'Responsable/Participante:') !!}
            <p>{!! nl2br($entrevistaIndividual->fmt_fr) !!}</p>
        </div>
        <!-- Tipos de violencia -->
        <div class="form-group  col-sm-6">
            {!! Form::label('tv', 'Violencia registrada:') !!}
            <p>{!! nl2br($entrevistaIndividual->fmt_tv) !!}</p>
        </div>
        @elseif($entrevistaIndividual->id_subserie == config('expedientes.aa'))
            <!-- Fuerzas responsables -->
            <div class="form-group  col-sm-6">
                {!! Form::label('fr', 'Fuerzas en las que hace/hacía parte:') !!}
                <p>{!! nl2br($entrevistaIndividual->fmt_fr) !!}</p>
            </div>
            <!-- Temas AA-->
            <div class="form-group  col-sm-6">
                {!! Form::label('aa', 'Temas abordados:') !!}
                <p>{!! nl2br($entrevistaIndividual->fmt_aa) !!}</p>
            </div>
        @elseif($entrevistaIndividual->id_subserie == config('expedientes.tc'))
            <!-- Sectores AA-->
            <div class="form-group  col-sm-6">
                {!! Form::label('stc', 'Sectores en los que hace/hacía parte:') !!}
                <p>{!! nl2br($entrevistaIndividual->fmt_stc) !!}</p>
            </div>
            <!-- Temas AA-->
            <div class="form-group  col-sm-6">
                {!! Form::label('tc', 'Temas abordados:') !!}
                <p>{!! nl2br($entrevistaIndividual->fmt_tc) !!}</p>
            </div>
        @endif
        {{-- Analisis preliminar --}}
        {{-- Interes para  --}}
        <div class="form-group  col-sm-12">
            {!! Form::label('interes', 'Es de utilidad para el/los núcleos de:') !!}
            <p>{!! $entrevistaIndividual->fmt_interes !!}</p>
        </div>
        {{-- Interes areaa  --}}
        <div class="form-group  col-sm-12">
            {!! Form::label('interes', 'Puede ser de utilidad para el/las área/s de:') !!}
            <p>{!! $entrevistaIndividual->fmt_interes_area !!}</p>
        </div>
        {{-- Mandato  --}}
        <div class="form-group  col-sm-12">
            {!! Form::label('mandato', 'Coincide con los siguientes puntos del mandato:') !!}
            <p>{!! $entrevistaIndividual->fmt_mandato !!}</p>
        </div>
        {{-- Mandato  --}}
        <div class="form-group  col-sm-12">
            {!! Form::label('dinamicas', 'Dinámicas identificadas:') !!}
            <p>{!! $entrevistaIndividual->fmt_dinamica !!}</p>
        </div>

        <!-- Anotaciones Field -->
        <div class="form-group  col-sm-12">
            {!! Form::label('anotaciones', 'Anotaciones:') !!}
            <p style="word-wrap:break-word;">{!! nl2br($entrevistaIndividual->anotaciones) !!}</p>
        </div>
        {{-- Enlaces y unificaciones --}}
        @php($listado_enlaces = \App\Models\enlace::listado_enlaces($entrevistaIndividual->id_subserie,$entrevistaIndividual->id_e_ind_fvt))
        @if(count($listado_enlaces)>0)
            <div class="col-sm-12">
            {!! Form::label('enlaces', 'Enlaces con otras entrevistas:') !!}
            @include('partials.tabla_enlaces')
            </div>
        @endif

        <div class="clearfix"></div>


