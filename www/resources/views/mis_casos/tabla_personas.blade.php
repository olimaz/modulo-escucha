@php($listado = $misCasos->rel_personas()->where('id_activo',1)->get() )

<div class="box box-info ">
    <div class="box-body no-padding table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th width="10px">#</th>
                    <th>Nombre</th>
                    <th>Sexo</th>
                    <th>Forma de contacto</th>
                    <th>¿Contactado/a?</th>
                    <th>¿Entrevistado/a?</th>
                    <th>Fecha de la entrevista</th>
                    <th>Código entrevista</th>
                    @can('sistema-abierto')
                    @if($misCasos->puede_modificar_entrevista())
                        <th>Acciones</th>
                    @endif
                    @endcan
                </tr>
            </thead>
            @php($i=1)
            @foreach($listado as $item)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->fmt_id_sexo }}</td>
                    <td>{{ $item->contacto }}</td>
                    <td >
                        @can('sistema-abierto')
                        {!! Form::open(['action' => ['mis_casos_personaController@update_contactada',$item->id_mis_casos_persona], 'id'=>'frm_'.$item->id_mis_casos_persona] ) !!}
                        <label class="radio-inline icheck icheck_submit">
                            <input type="checkbox" name='id_contactado' class="flat-green" {{ $item->id_contactado==1 ? "checked" : "" }} {{  in_array($misCasos->privilegios,[1,5]) ? " " : "disabled" }} >
                        </label>
                        {!! Form::close() !!}
                        @else
                            {{ $item->id_contactado==1 ? "Sí" : "No" }}
                        @endcan
                    </td>
                    <td >
                        @can('sistema-abierto')
                        {!! Form::open(['action' => ['mis_casos_personaController@update_entrevistada',$item->id_mis_casos_persona], 'id'=>'frm_'.$item->id_mis_casos_persona] ) !!}
                        <label class="radio-inline icheck icheck_submit">
                            <input type="checkbox" name='id_entrevistado' class="flat-green" {{ $item->id_entrevistado==1 ? "checked" : "" }} {{ in_array($misCasos->privilegios,[1,5]) ? " " : "disabled" }} >
                        </label>
                        {!! Form::close() !!}
                        @else
                            {{ $item->id_entrevistado==1 ? "Sí" : "No" }}
                        @endcan
                    </td>
                    <td>
                        {{ $item->fmt_entrevista_fecha_hora }}
                    </td>
                    <td>
                        {!! $item->fmt_entrevista  !!}
                    </td>
                    @can('sistema-abierto')
                    @if(in_array($misCasos->privilegios,[1,5]))
                        <td width="100px">
                            {!! Form::open(['action' => ['mis_casos_personaController@destroy',$item->id_mis_casos_persona], 'id'=>'frm_'.$item->id_mis_casos_persona, 'method' => 'delete'] ) !!}
                            <div class='btn-group'>
                                <a href="{{ route('misCasosPersonas.edit', [$item->id_mis_casos_persona]) }}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar esta persona" data-toggle="tooltip" onclick="return confirm('Esta segura?')"><i class="fa fa-trash-o"></i></button>
                            </div>
                            {!! Form::close() !!}
                        </td>
                    @endif
                    @endif
                </tr>
                @if($item->anotaciones)
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="5"><b>Anotaciones:</b> {!! nl2br($item->anotaciones) !!}</td>
                    </tr>
                @endif
            @endforeach

        </table>
    </div>
    <hr>
</div>

@can('sistema-abierto')
    @if(in_array($misCasos->privilegios,[1,5]))
        @php($misCasosPersona = new \App\Models\mis_casos_persona())
        {!! Form::model($misCasosPersona, ['action' => 'mis_casos_personaController@store']) !!}
        <div class="col-sm-10 col-sm-offset-1">
            <div class="box box-default {{ count($listado)>0 ? " collapsed-box " : "" }} box-solid">
                <div class="box-header">
                    <h3 class="box-title">
                        @if(count($listado)>0)
                            Expandir este espacio para agregar mas personas
                        @else
                            Agregar nueva persona
                        @endif
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>

                </div>
                <div class="box-body">
                    <input type="hidden" name="id_mis_casos" value="{{ $misCasos->id_mis_casos }}">
                    @include("mis_casos_personas.fields")
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    @endif
@endif
    <div class="clearfix"></div>


@push('js')
    <script>
        $(document).ready(function(){
            $('.icheck').iCheck({
                checkboxClass: 'iradio_square-green',
                radioClass: 'iradio_square-green',
                increaseArea: '20%' // optional
            });

            $('.icheck_submit').on('ifChanged', function(event){
               // $(this.closest('form').submit());
            });

        });
    </script>

@endpush