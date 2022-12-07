@extends('layouts.app')

@section('content_header')
    <h1 class="page-header">
        {{ $entrevista->entrevista_codigo }} - Ficha de impactos de los hechos
        <div class="pull-right">
            <a href="{!! action('entrevista_individualController@fichas',$entrevista->id_e_ind_fvt) !!}" class="btn btn-default">Volver</a>
        </div>
    </h1>


@endsection

@section('content')
        @include('adminlte-templates::common.errors')
        <div class="col-sm-6">
            <div class="box box-primary box-solid">
                <div class="box-header">
                    <h3 class="box-title">A. Impactos de los hechos</h3>
                </div>
                <div class="box-body">

                    <h3>1. Impactos individuales</h3>
                    <div class="form-group col-xs-12">
                        <label>1.1 ¿Qué cambió en su vida?</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,132) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>

                    </div>
                    <div class="form-group col-xs-12">
                        <label>1.2 Impactos emocionales que permanecen en el tiempo:</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,133) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>

                    </div>
                    <div class="form-group col-xs-12">
                        <label>1.3 Impactos en la salud (física y psicológica):</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,134) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <h3>2. Impactos relacionales</h3>
                    <div class="form-group col-xs-12">
                        <label>2.1 Impactos a los familiares de las víctimas</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,135) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group col-xs-12">
                        {!! Form::label('transgeneracionales', '2.2 Impactos transgeneracionales: ') !!}
                        <ul>
                            <li> {{ $impacto->transgeneracionales }}</li>
                        </ul>
                    </div>

                    <div class="form-group col-xs-12">
                        <label>2.3 Impactos en la red social personal (vecinos, amigos,  barrio, comunidad)</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,136) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <h3>3. Revictimización</h3>

                    <div class="form-group col-xs-12">
                        <label3.1 Indique si hubo formas de revictimización como consecuencia de los hechos</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,137) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>


                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box box-primary box-solid">
                <div class="box-header">
                    <h3 class="box-title">B. Impactos colectivos</h3>
                </div>
                <div class="box-body">


                    <div class="form-group col-xs-12">
                        <label>1. Impactos colectivos derivados de los hechos</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,138) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>2. Impactos a sujetos colectivos étnicos-raciales</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,139) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>3. Impactos ambientales y al territorio</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,140) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>


                    <div class="form-group col-xs-12">
                        <label>4. Impactos a los derechos sociales y económicos</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,141) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>5. Impactos culturales</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,142) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>6. Impactos políticos y a la democracia</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,143) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">C. Afrontamiento y resistencia</h3>
                </div>
                <div class="box-body">
                    <div class="col-sm-6">
                        <h3>1. Afrontamiento individual</h3>
                        <div class="form-group col-xs-12">
                            <label>Cuando ocurrieron los hechos, ¿que hizo para afrontar/manejar la situación?</label>
                            <ul>
                                @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,144) as $txt)
                                    <li>{{ $txt }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <h3>2. Afrontamiento familiar</h3>
                        <div class="form-group col-xs-12">
                            <label>Como familia, ¿Hicieron algo para afrontar/manejar la situación?</label>
                            <ul>
                                @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,145) as $txt)
                                    <li>{{ $txt }}</li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <h3>3. Afrontamiento colectivo</h3>
                        <div class="form-group col-xs-12">
                            <label>3.1 Para manejar la situación, participó o participa en:</label>
                            <ul>
                                @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,146) as $txt)
                                    <li>{{ $txt }}</li>
                                @endforeach
                            </ul>

                        </div>
                        <div class="form-group col-xs-12">
                            {!! Form::label('afrentamiento_proceso', 'Indique el nombre del proceso colectivo/iniciativa: ') !!}
                            {!! $impacto->afrentamiento_proceso !!}
                        </div>

                        <div class="form-group col-xs-12">
                            <label>3.2 Durante su participación en el proceso colectivo, tuvo/tiene dificultades:</label>
                            <ul>
                                @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,147) as $txt)
                                    <li>{{ $txt }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="form-group col-xs-12">
                            <label>3.3 El proceso / La inciativa fortaleció:</label>
                            <ul>
                                @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,148) as $txt)
                                    <li>{{ $txt }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="clearfix"></div>
        <div class="col-xs-12">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">D. Acceso a la justicia, reparación y no repetición</h3>
                </div>
                <div class="box-body">
                    <div class="form-group col-sm-6">
                        <label>1. ¿Puso en conocimiento a alguna entidad o autoridad?</label> <br>
                        {{  $entrevista_justicia->fmt_id_denuncio }}
                    </div>
                    <div class="form-group col-sm-6" id="div_denuncio">
                        <label>¿Por qué no?:</label> <br>
                        {!!  $entrevista_justicia->porque_no !!}
                    </div>



                    <div class="clearfix"></div>
                    <div class="col-sm-12">
                        <h4 >Estatal</h4>
                    </div>
                    <div class="col-sm-4">
                        <label>Autoridad/entidad</label> <br>
                        <ul>
                            @foreach(\App\Models\justicia_institucion::arreglo_institucion_txt($entrevista->id_e_ind_fvt,1) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <label>¿Por qué accedió a esta entidad o autoridad?</label> <br>
                        <ul>
                            @foreach(\App\Models\justicia_porque::arreglo_porque_txt($entrevista->id_e_ind_fvt,1) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <label>¿Cuál era su objetivo principal al acceder a esta vía?</label> <br>
                        <ul>
                            @foreach(\App\Models\justicia_objetivo::arreglo_objetivo_txt($entrevista->id_e_ind_fvt,1) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>


                    <div class="clearfix"></div>


                    {{-- COMUNITARIO --}}
                    <div class="col-sm-12">
                        <h4 >Comunitario</h4>
                    </div>
                    <div class="col-sm-4">
                        <label>Autoridad/entidad</label> <br>
                        <ul>
                            @foreach(\App\Models\justicia_institucion::arreglo_institucion_txt($entrevista->id_e_ind_fvt,2) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <label>¿Por qué accedió a esta entidad o autoridad?</label> <br>
                        <ul>
                            @foreach(\App\Models\justicia_porque::arreglo_porque_txt($entrevista->id_e_ind_fvt,2) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <label>¿Cuál era su objetivo principal al acceder a esta vía?</label> <br>
                        <ul>
                            @foreach(\App\Models\justicia_objetivo::arreglo_objetivo_txt($entrevista->id_e_ind_fvt,2) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="clearfix"></div>


                    {{-- Internacional --}}
                    <div class="col-sm-12">
                        <h4 >Internacional</h4>
                    </div>

                    <div class="col-sm-4">
                        <label>Autoridad/entidad</label> <br>
                        <ul>
                            @foreach(\App\Models\justicia_institucion::arreglo_institucion_txt($entrevista->id_e_ind_fvt,3) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <label>¿Por qué accedió a esta entidad o autoridad?</label> <br>
                        <ul>
                            @foreach(\App\Models\justicia_porque::arreglo_porque_txt($entrevista->id_e_ind_fvt,3) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <label>¿Cuál era su objetivo principal al acceder a esta vía?</label> <br>
                        <ul>
                            @foreach(\App\Models\justicia_objetivo::arreglo_objetivo_txt($entrevista->id_e_ind_fvt,3) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="clearfix"></div>



                    {{-- Resto del formulario --}}


                    <div class="form-group col-sm-6">
                        <label>2. ¿Ha recibido apoyo para su caso? </label><br>
                        {{ $entrevista_justicia->fmt_id_apoyo }}
                    </div>

                    <div class="form-group col-sm-6" id="div_apoyo">
                        <label>Especifique</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,155) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group col-xs-12" >
                        <h4>3. ¿Qué avances ha tenido su caso?</h4>
                    </div>

                    <div class="form-group col-sm-6" >
                        <label>3.1 Responsable sancionado</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,160) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>

                    </div>
                    <div class="form-group col-sm-6" >
                        <label>3.2 Verdad esclarecida</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,161) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group col-sm-6" >
                        <label>3.3 Reparación</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,163) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group col-sm-6" >
                        <label>3.4 Si no hubo avances, ¿Por qué?</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,162) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="form-group col-xs-12" >
                        <h4>4. ¿Qué medidas de reparación individual ha recibido?</h4>
                    </div>

                    <div class="form-group col-sm-6" >
                        <label>4.1 Indemnización individual</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,164) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group col-sm-6" >
                        <label>4.2 Medidas de restablecimiento de derechos</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,165) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group col-sm-6" >
                        <label>4.3 Medidas de rehabilitación</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,166) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group col-sm-6" >
                        <label>4.4 Medidas de satisfacción</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,167) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group col-sm-6" >
                        <label>4.5 Otras medidas</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,168) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12" >
                        <label>5. Estado de avance de la reparación colectiva</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,169) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="form-group col-sm-6">
                        <label>6. Las medidas de reparación, ¿han sido adecuadas?</label><br>
                        {{ $entrevista_justicia->fmt_id_adecuado }}
                    </div>
                    @if($entrevista_justicia->fmt_id_adecuado == 2)
                        <div class="form-group col-sm-6" id="div_adecuado" >
                            <label>¿Por qué?</label>
                            <ul>
                                @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,170) as $txt)
                                    <li>{{ $txt }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group col-sm-12" >
                        <label>¿Qué se necesita para que estos hechos no se vuelvan a repetir?</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_e_ind_fvt,171) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="box-footer">
                    <a href="{!! action('entrevista_individualController@fichas',$entrevista->id_e_ind_fvt) !!}" class="btn btn-default">Volver</a>

                </div>
            </div>
        </div>
        <div class="clearfix"></div>
@endsection

