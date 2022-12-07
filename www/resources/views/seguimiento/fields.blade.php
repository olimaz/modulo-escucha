{{-- Para el formualario de problemas --}}
@php($ocultar_cierre = isset($ocultar_cierre) ? $ocultar_cierre : false)

@php($i=1)
@php($listado_problemas=\App\Models\cat_item::listado_items(75))
@foreach($listado_problemas as $id_tipo_problema => $txt_tipo_problema)
    <div class="form-group col-sm-12">
        @include('controles.radio_si_no_cual', ['control_control' => 'id_tipo_problema_'.$id_tipo_problema
                                                 ,'control_id' =>'id_tipo_problema_'.$id_tipo_problema
                                                 ,'control_texto' =>$txt_tipo_problema.": "
                                                 ,'control_control_cual' =>'problema_'.$id_tipo_problema.'_especifique'
                                                 ,'control_texto_cual' =>'Especifique'
                                                 ,'control_tipo' =>2
                                                 ])
    </div>
@endforeach

@if(!$ocultar_cierre)
    <div class="form-group col-sm-6">
        @if(isset($seguimiento))
            @include('controles.radio_si_no', ['control_control' => 'id_cerrado'
                                                 ,'control_texto' => "A criterio del transcriptor/etiquetador, el procesamiento de esta entrevista se considera finalizado.  <br> <span class='text-muted'>(Si la respuesta es afirmativa, la entrevista se clasifica como 'cerrada' y no será posible realizarle cambios)</span>: "
                                                    ,'control_default' => $seguimiento->entrevista->entrevista->id_cerrado
                                                 ])
        @else
            @include('controles.radio_si_no', ['control_control' => 'id_cerrado'
                                                 ,'control_texto' => "A criterio del transcriptor/etiquetador, el procesamiento de esta entrevista se considera finalizado.  <br> <span class='text-muted'>(Si la respuesta es afirmativa, la entrevista se clasifica como 'cerrada' y no será posible realizarle cambios)</span>: "

                                                 ])
        @endif
    </div>
    <div class="form-group col-sm-6">
        {!! Form::label('anotaciones','Anotaciones respecto a la finalización del procesamiento de la entrevista (opcionales):') !!}
        {!! Form::textarea('anotaciones', null, ['class' => 'form-control','rows'=>3]) !!}
    </div>
@endif


