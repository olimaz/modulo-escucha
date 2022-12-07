@extends('layouts.app')

@section('content_header')
    <h1 class="page-header">
        @php
         $titulo = ($tipo_entrevista == 'individual' ? 'Ficha de impactos de los hechos':'Ficha de impactos relacionales y sobre la salud colectiva');
        @endphp
        {{ $entrevista->entrevista_codigo }} - {{$titulo}}
        <div class="pull-right">
            @if ($tipo_entrevista == 'individual')
                <a href="{!! action('entrevista_individualController@fichas',$entrevista->id_entrevista) !!}" class="btn btn-default">Volver</a>    
            @else                        
                <a href="{!! action('entrevista_etnicaController@fichas',$entrevista->id_entrevista) !!}" class="btn btn-default">Volver</a>    
            @endif            
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
                    @php 
                        $titulo = ($tipo_entrevista=='individual' ? '1. Impactos individuales' : '1. Impactos sobre las comunidades');
                    @endphp    
                    <h3>{{$titulo}}</h3>
                    

                    @if ($tipo_entrevista=='individual')
                        
                        <div class="form-group col-xs-12">
                            <label>1.1 ¿Qué cambió en su vida?</label>
                            <ul>
                                @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,132, $tipo_entrevista) as $txt)
                                    <li>{{ $txt }}</li>
                                @endforeach
                            </ul>

                        </div>
                    @endif
                    <div class="form-group col-xs-12">
                        @php 
                            $label = ($tipo_entrevista=='individual' ? '1.2 Impactos emocionales que permanecen en el tiempo:' : '1.1 Impactos emocionales que permanecen en el tiempo:');
                        @endphp                            
                        <label>{{$label}}</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,133, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>

                    </div>
                    <div class="form-group col-xs-12">
                        @php 
                            $label = ($tipo_entrevista=='individual' ? '1.3 Impactos en la salud (física y psicológica):' : '1.2 Impactos en la salud colectiva (física y psicológica):');
                            $cat_cat = ($tipo_entrevista=='individual' ? 134 : 276);
                        @endphp                        
                        <label>{{$label}}</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,$cat_cat, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <h3>2. Impactos relacionales</h3>
                    <div class="form-group col-xs-12">
                        @php 
                            $label = ($tipo_entrevista=='individual' ? '2.1 Impactos a los familiares de las víctimas' : '2.1 Impactos a las familias de la comunidad');                            
                        @endphp                          
                        <label>{{$label}}</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,135,$tipo_entrevista) as $txt)
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
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,136, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <h3>3. Revictimización</h3>

                    <div class="form-group col-xs-12">
                        <label3.1 Indique si hubo formas de revictimización como consecuencia de los hechos</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,137, $tipo_entrevista) as $txt)
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
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,138, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>2. Impactos a sujetos colectivos étnicos-raciales</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,139, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>3. Impactos ambientales y al territorio</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,140, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>


                    <div class="form-group col-xs-12">
                        <label>4. Impactos a los derechos sociales y económicos</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,141, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>5. Impactos culturales</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,142, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group col-xs-12">
                        <label>6. Impactos políticos y a la democracia</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,143, $tipo_entrevista) as $txt)
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
                        @php
                            $etiqueta = ($tipo_entrevista == 'individual' ? '1. Afrontamiento individual' : '1. Afrontamientos colectivos');
                            $pregunta = ($tipo_entrevista == 'individual' ? 'Cuando ocurrieron los hechos, ¿qué hizo para afrontar/manejar la situación?' : 'Cuando ocurrieron los hechos, ¿qué hicieron para afrontar/manejar la situación?');
                        @endphp                        
                        <h3>{{$etiqueta}}</h3>
                        <div class="form-group col-xs-12">
                            <label>{{$pregunta}}</label>
                            <ul>
                                @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,144, $tipo_entrevista) as $txt)
                                    <li>{{ $txt }}</li>
                                @endforeach
                            </ul>
                        </div>

                        @if ($tipo_entrevista == 'individual')
                        <h3>2. Afrontamiento familiar</h3>
                        <div class="form-group col-xs-12">
                            <label>Como familia, ¿Hicieron algo para afrontar/manejar la situación?</label>
                            <ul>
                                @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,145, $tipo_entrevista) as $txt)
                                    <li>{{ $txt }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                    </div>
                    <div class="col-sm-6">
                        @if ($tipo_entrevista == 'individual')
                            <h3>3. Afrontamiento colectivo</h3>
                            @php
                                $label = '3.1 Para manejar la situación, participó o participa en:';
                            @endphp
                        @else                             
                            <h3>2. Para manejar/afrontar la situación, la comunidad participó o participa en:</h3>
                            @php
                                $label = ' ';
                            @endphp                            
                        @endif                        
                        {{-- <h3>3. Afrontamiento colectivo</h3> --}}
                        <div class="form-group col-xs-12">
                            <label>{{$label}}</label>
                            <ul>
                                @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,146, $tipo_entrevista) as $txt)
                                    <li>{{ $txt }}</li>
                                @endforeach
                            </ul>

                        </div>
                        <div class="form-group col-xs-12">
                            @php
                                $etiqueta = ($tipo_entrevista=='individual' ? 'Indique el nombre del proceso colectivo/iniciativa: ' : '2.1 Menciona el nombre del proceso colectivo/iniciativa: '); 
                            @endphp                                      
                            {!! Form::label('afrentamiento_proceso', $etiqueta) !!}
                            {!! $impacto->afrentamiento_proceso !!}
                        </div>

                        <div class="form-group col-xs-12">
                            @php
                                $etiqueta = ($tipo_entrevista=='individual' ? '3.2 Durante su participación en el proceso colectivo, tuvo/tiene dificultades:' : '2.2 El proceso colectivo, tuvo/tiene dificultades:'); 
                            @endphp                             
                            <label>{{$etiqueta}}</label>
                            <ul>
                                @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,147, $tipo_entrevista) as $txt)
                                    <li>{{ $txt }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="form-group col-xs-12">
                            @php
                                $etiqueta = ($tipo_entrevista=='individual' ? '3.3 El proceso / La inciativa fortaleció:' : '2.3 El proceso / La inciativa colectiva fortaleció:'); 
                            @endphp                               
                            <label>{{$etiqueta}}</label>
                            <ul>
                                @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,148, $tipo_entrevista) as $txt)
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
                            @foreach(\App\Models\justicia_institucion::arreglo_institucion_txt($entrevista->id_entrevista,1, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <label>¿Por qué accedió a esta entidad o autoridad?</label> <br>
                        <ul>
                            @foreach(\App\Models\justicia_porque::arreglo_porque_txt($entrevista->id_entrevista,1, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <label>¿Cuál era su objetivo principal al acceder a esta vía?</label> <br>
                        <ul>
                            @foreach(\App\Models\justicia_objetivo::arreglo_objetivo_txt($entrevista->id_entrevista,1, $tipo_entrevista) as $txt)
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
                            @foreach(\App\Models\justicia_institucion::arreglo_institucion_txt($entrevista->id_entrevista,2, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <label>¿Por qué accedió a esta entidad o autoridad?</label> <br>
                        <ul>
                            @foreach(\App\Models\justicia_porque::arreglo_porque_txt($entrevista->id_entrevista,2, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <label>¿Cuál era su objetivo principal al acceder a esta vía?</label> <br>
                        <ul>
                            @foreach(\App\Models\justicia_objetivo::arreglo_objetivo_txt($entrevista->id_entrevista,2, $tipo_entrevista) as $txt)
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
                            @foreach(\App\Models\justicia_institucion::arreglo_institucion_txt($entrevista->id_entrevista,3, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <label>¿Por qué accedió a esta entidad o autoridad?</label> <br>
                        <ul>
                            @foreach(\App\Models\justicia_porque::arreglo_porque_txt($entrevista->id_entrevista,3, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <label>¿Cuál era su objetivo principal al acceder a esta vía?</label> <br>
                        <ul>
                            @foreach(\App\Models\justicia_objetivo::arreglo_objetivo_txt($entrevista->id_entrevista,3, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="clearfix"></div>



                    {{-- Resto del formulario --}}


                    <div class="form-group col-sm-6">
                        @php 
                            $etiqueta = ($tipo_entrevista == 'individual' ? '2. ¿Ha recibido apoyo para su caso?' : '2. ¿La comunidad ha recibido apoyo para su caso?');
                        @endphp                        
                        <label>{{$etiqueta}} </label><br>
                        {{ $entrevista_justicia->fmt_id_apoyo }}
                    </div>

                    <div class="form-group col-sm-6" id="div_apoyo">
                        <label>Especifique</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,155, $tipo_entrevista) as $txt)
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
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,160, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>

                    </div>
                    <div class="form-group col-sm-6" >
                        <label>3.2 Verdad esclarecida</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,161, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @if ($tipo_entrevista=='individual') 
                        <div class="form-group col-sm-6" >
                            <label>3.3 Reparación</label>
                            <ul>
                                @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,163, $tipo_entrevista) as $txt)
                                    <li>{{ $txt }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="form-group col-sm-6" >
                            <label>3.4 Si no hubo avances, ¿Por qué?</label>
                            <ul>
                                @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,162, $tipo_entrevista) as $txt)
                                    <li>{{ $txt }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @else 
                        <div class="form-group col-sm-6" >
                            <label>3.3 Si no hubo avances, ¿Por qué?</label>
                            <ul>
                                @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,162, $tipo_entrevista) as $txt)
                                    <li>{{ $txt }}</li>
                                @endforeach
                            </ul>
                        </div> 
                        <div class="form-group col-sm-6" >
                            <label>3.4 Reparación</label>
                            <ul>
                                <li>
                                    {{ $impacto->id_reparacion_etnica != null ? $impacto->rel_id_reparacion_etnica->descripcion : 'Sin especificar / No aplica'}}
                                </li>
                            </ul>
                        </div>                                           
                    @endif

                    <div class="form-group col-xs-12" >
                        @php
                            $titulo = ($tipo_entrevista=='individual' ? '4. ¿Qué medidas de reparación individual ha recibido?' : '4. ¿Qué medidas de reparación han recibido?');
                        @endphp                        
                        <h4>{{$titulo}}</h4>
                    </div>

                    @if($tipo_entrevista=='individual')
                    <div class="form-group col-sm-6" >
                        <label>4.1 Indemnización individual</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,164, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="form-group col-sm-6" >
                        @php
                            $etiqueta = ($tipo_entrevista=='individual' ? '4.2 Medidas de restablecimiento de derechos' : '4.1 Medidas de restablecimiento de derechos');
                        @endphp                        
                        <label>{{$etiqueta}}</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,165, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @if ($tipo_entrevista=='individual')
                    <div class="form-group col-sm-6" >
                        <label>4.3 Medidas de rehabilitación</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,166, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="form-group col-sm-6" >
                        @php
                            $etiqueta = ($tipo_entrevista=='individual' ? '4.4 Medidas de satisfacción' : '4.2 Medidas de satisfacción');
                        @endphp                         
                        <label>{{$etiqueta}}</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,167, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @if ($tipo_entrevista=='individual')
                    <div class="form-group col-sm-6" >
                        <label>4.5 Otras medidas</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,168, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12" >
                        <label>5. Estado de avance de la reparación colectiva</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,169, $tipo_entrevista) as $txt)
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
                                @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,170, $tipo_entrevista) as $txt)
                                    <li>{{ $txt }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group col-sm-12" >
                        <label>¿Qué se necesita para que estos hechos no se vuelvan a repetir?</label>
                        <ul>
                            @foreach(\App\Models\entrevista_impacto::arreglo_impacto_txt($entrevista->id_entrevista,171, $tipo_entrevista) as $txt)
                                <li>{{ $txt }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="box-footer">
                    {{-- <a href="{!! action('entrevista_individualController@fichas',$entrevista->id_e_ind_fvt) !!}" class="btn btn-default">Volver</a> --}}
                    @if ($tipo_entrevista == 'individual')
                        <a href="{!! action('entrevista_individualController@fichas',$entrevista->id_entrevista) !!}" class="btn btn-default">Volver</a>    
                    @else                        
                        <a href="{!! action('entrevista_etnicaController@fichas',$entrevista->id_entrevista) !!}" class="btn btn-default">Volver</a>    
                    @endif                    

                </div>
            </div>
        </div>
        <div class="clearfix"></div>
@endsection

