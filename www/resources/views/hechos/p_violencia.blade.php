{{-- Detalle de violencia agregada --}}
<div class="col-sm-12">
    <div class="box box-solid {{ count($hecho->rel_violencia)==0 ? ' box-danger ' :' box-success ' }}">
        <div class="box-header">
            <h3 class="box-title">
                @if ($hecho->tipo_expediente()=='individual')
                    2. Tipos de violencias en este hecho    
                @else
                    1. Tipos de violencias en este hecho
                @endif
                
            </h3>

        </div>
        <div class="box-body bg-gray no-padding"> {{-- probé con div y queda mejor con tabla :-\ --}}
            @if(count($hecho->rel_violencia)==0)
                <div class="text-yellow text-center">
                    <h4><i class="icon fa fa-warning"></i> Atención</h4>
                    No se ha especificado ninguna violencia
                </div>
            @else
                <table class="table table-condensed ">
                    @foreach($hecho->rel_violencia as $violencia)
                        <tr>
                            <td>
                                {!! $violencia->descripcion->nombre !!}
                            </td>

                            <td>
                                {!! Form::open(['action' => ['hecho_violenciaController@quitar', $violencia->id_hecho_violencia]]) !!}
                                <button type="submit"  class="btn btn-danger btn-sm" onclick = "return confirm('¿Segura?')">Quitar</button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
        <div class="box-footer no-padding">
            <div class="col-sm-12">
                @include('hechos.p_agregar_violencia')
            </div>
        </div>
    </div>
</div>