@extends('layouts.app')
@section('content_header')
    <h1 class="page-header">Normalización del vocabulario</h1>
    <h4>El ejercicio de reclasificación establece equivalencias entre las respuestas especificadas en las fichas y no sustituye el valor anterior por el nuevo, sino que mantiene ambos.</h4>
@endsection
@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">
                Reclasificación de respuestas
            </h3>
        </div>
        <div class="box-body">
            <form action="#" method="GET">
                <div class="col-sm-8">
                    <div class="form-group">
                        @include('controles.select_generico', ['control_control' => 'id_seleccionado'
                                              ,'control_listado'=>$listado_catalogos
                                              , 'control_default'=>$id_seleccionado
                                              , 'control_onchange'=>true
                                              ,'control_texto'=>'Seleccione el listado a reclasificar'])

                    </div>

                </div>
                <div class="col-sm-4">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="radio-inline icheck icheck_accion">
                            <input type="checkbox" class="minimal" name='filtrar' id="filtrar_pendientes"  {{ $filtrar==1 ? ' checked ' : "" }}>
                            Mostrar únicamente los pendientes de reclasificar
                        </label>

                    </div>

                </div>
            </form>
            <div class="clearfix"></div>
            <h3>Opciones para el listado: <span class="text-primary"> {{ $listado_catalogos[$id_seleccionado] }}</span></h3>
            <div class="table-responsive">
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            @can('sistema-abierto')
                                <th style="width: 150px">&nbsp;</th>
                            @endcan
                            <th>Texto original</th>
                            @can('sistema-abierto')
                                <th>&nbsp;</th>
                            @endcan
                            <th>Nuevo texto reclasificado</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php($i=$listado_items->firstItem())
                        @foreach($listado_items as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                @can('sistema-abierto')
                                <td class="text-center">
                                    <a href="{{ action('cat_itemController@frm_editar',$item->id_item)."?filtrar=$filtrar&page=".$listado_items->currentPage() }}" class="btn btn-warning ">
                                        <i class="fa fa-pencil"></i> Corregir el texto original
                                    </a>
                                </td>
                                @endcan
                                <td id="e_{{ $item->id_item }}" {!!   $id_cambiado == $item->id_item ? "class='text-primary'" : "" !!}>
                                    {{ $item->descripcion }}
                                </td>
                                @can('sistema-abierto')
                                <td>
                                    <a href="{{ action('cat_itemController@frm_reclasificar',$item->id_item)."?filtrar=$filtrar&page=".$listado_items->currentPage() }}" class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                         Reclasificar
                                    </a>
                                </td>
                                @endcan
                                <td id="r_{{ $item->id_item }}" {!!   $id_reclasificado == $item->id_item ? "class='text-primary'" : "" !!}>
                                    {!! $item->fmt_id_relacionado !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
        <div class="box-footer">

            <div class="no-print">
                {!! $listado_items->appends(Request::all())->render() !!}
            </div>

        </div>

    </div>
@endsection

@push("js")
    <script>
        $(function() {
            let donde = false;
            @if($id_cambiado > 0)
                 donde = "#e_{{ $id_cambiado }}";
            @endif

            @if($id_reclasificado > 0)
                @if($filtrar==0)
                    donde = "#r_{{ $id_reclasificado }}";
                @endif
            @endif
            if(donde) {
                $('html, body').animate({
                    scrollTop: $(donde).offset().top
                }, 800);
            }


            //////

                $('.icheck').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                    increaseArea: '20%' // optional
                });

                $('.icheck').on('ifChanged', recargar);
                function recargar() {
                    var filtrar = $('#filtrar_pendientes').iCheck('update')[0].checked;
                    let cola=0;
                    if(filtrar) {
                        cola=1;
                    }
                    let url = "{!!   Request::url()."?id_seleccionado=$id_seleccionado"."&filtrar=" !!}"+cola;
                    document.location=url;
                    //alert(url);
                }

        });

    </script>

@endpush