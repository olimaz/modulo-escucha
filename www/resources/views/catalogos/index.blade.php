@extends("layouts.app")
@section('title', 'Catalogos del sistema')
@section('content_header')
    <h1>Parametrización del sistema <small>opciones personalizables.</small></h1>
@stop


@section("content")
        <div class="box box-primary">
            <div class="box-header">
                <div class="row">
                    {!! Form::model($filtros, ['url' => "#", 'method'=>'GET'])  !!}
                    <div class="form-group col-xs-6">
                        {!! Form::label('id_cat',"Listado") !!}
                        {!! Form::select('id_cat', $catalogos, null, ["class"=>"form-control","onchange"=>"submit()"]) !!}
                    </div>
                    <div class="form-group col-xs-3">
                        {!! Form::label('habilitado',"¿Se muestra en el listado?") !!}
                        {!! Form::select('habilitado', [-1=>"Mostrar todos",1=>"Sí",2=>"No"], null, ["class"=>"form-control","onchange"=>"submit()"]) !!}
                    </div>
                    <div class="form-group col-xs-3">
                        {!! Form::label('pendiente_revisar',"¿Pendiente de revisar?") !!}
                        {!! Form::select('pendiente_revisar', [-1=>"Mostrar todos",1=>"Sí",2=>"No"], null, ["class"=>"form-control","onchange"=>"submit()"]) !!}
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
            <div class="box-body table-responsive ">



                <h4>Opciones para <b>{{  \App\Models\cat_cat::find($id_cat)->nombre_cat  }}</b></h4>
                @can('sistema-abierto')
                    @can('rol-tesauro')
                        <a href="{{ action("cat_itemController@create",$id_cat) }}" class="btn  btn-primary pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Agregar nueva opción</a>
                    @endcan
                @endcan
                <table class="table table-hover table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Descripción</th>
                            <th>Pendiente de revisar</th>

                            <th>Orden</th>
                            <th>Predeterminado</th>
                            <th>¿Se muestra en el listado?</th>
                            @if($id_cat==3)
                                <th>Coordenadas</th>
                            @endif
                            @can('sistema-abierto')
                                @can('rol-tesauro')
                                    <th width="200px">Edición</th>
                                @endcan
                            @endcan
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($items as $id=>$opcion)
                            @php( $color_fila = $opcion->pendiente_revisar==1 ? " text-danger " : "" )
                            @php( $color_fila = $opcion->habilitado<>1 ? " text-muted " : $color_fila )
                            <tr  class="{{ $color_fila }}">
                                <td>{{ ++$id }}</td>
                                <td>{{ $opcion->descripcion }}</td>
                                <td class="text-center">
                                    {!! $opcion->pendiente_revisar==1 ? "Sí" : "No" !!}

                                </td>
                                <td class="text-center">{{ $opcion->orden }}</td>

                                <td class="text-center">{{ $opcion->fmt_predeterminado }}</td>
                                <td class="text-center">
                                    {!! $opcion->habilitado==1 ? "Sí" : "No" !!}
                                </td>
                                @if($id_cat==3)
                                    <td class="text-center">
                                    @if($opcion->lat && $opcion->lon)
                                         {{ number_format($opcion->lat,6) }}, {{ number_format($opcion->lon,6) }}
                                    @else
                                            S.E.
                                    @endif
                                    </td>
                                @endif
                                @can('sistema-abierto')
                                    @can('rol-tesauro')
                                        <td >
                                            {!! Form::open(['action' => ['cat_itemController@destroy', $opcion->id_item], 'method' => 'delete']) !!}
                                            <div class='btn-group'>
                                                <a href="{{ action('cat_itemController@edit',$opcion->id_item) }}" class="btn btn-info btn-sm " data-toggle="tooltip" data-placement="top" title="Modificar opción"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a>
                                                @if($opcion->habilitado==1)
                                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i> Deshabilitar', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('¿Confirma que desea deshabilitar la opción indicada?')","data-toggle"=>"tooltip", "data-placement">="top", "title"=>"Deshabilitar opción"]) !!}
                                                @else
                                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i> Habilitar', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', 'onclick' => "return confirm('¿Confirma que desea habilitar la opción indicada?')","data-toggle"=>"tooltip", "data-placement">="top", "title"=>"Habilitar opción"]) !!}
                                                @endif
                                            </div>
                                            {!! Form::close() !!}
                                        </td>
                                    @endcan
                                @endcan
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                Referencias:
                <ul>
                    <li>Las opciones se muestran en el orden que se listas en los controles, el cual es primero por la columna "orden" y luego por la descripción. </li>
                    <li>Las opciones marcadas como predeterminadas son las que se seleccionan automáticamente en los formularios nuevos </li>
                    <li>Las opciones que ¿se muestran en el listado? con valor "No", son aquellas que han sido re clasificadas. Siguen existiendo en el listado, pero ya no se muestran.</li>
                </ul>
            </div>
        </div>


@endsection


@push("js")
    <script>
        var control ='#id_cat';
        $(control).select2({
            placeholder: 'Seleccione una opción'
        });
        var control ='#habilitado';
        $(control).select2({
            placeholder: 'Seleccione una opción'
        });
        var control ='#pendiente_revisar';
        $(control).select2({
            placeholder: 'Seleccione una opción'
        });


        //$("#id_cat").val({{ $id_cat }});
        //ß$("#id_cat").trigger('change');
    </script>

@endpush