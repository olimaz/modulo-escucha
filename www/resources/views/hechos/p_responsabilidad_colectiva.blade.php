{{-- Responsabilidad colectiva --}}
<div class="clearfix"></div>
<div class="col-sm-12">
    <div class="box box-solid  {{ count($hecho->rel_responsabilidad)==0 ? ' box-danger ' :' box-success ' }}">
        <div class="box-header">
            <h3 class="box-title">
                @if ($hecho->tipo_expendiente=='individual')
                    4. Responsabilidad colectiva    
                @else 
                    2. Responsabilidad colectiva
                @endif
                
            </h3>

        </div>
        <div class="box-body  no-padding">
            @if(count($hecho->rel_responsabilidad)==0)
                <div class="text-yellow text-center">
                    <h4><i class="icon fa fa-warning"></i> Atención</h4>
                    No se ha especificado ninguna responsabilidad colectiva
                </div>
            @else
                <table class="table table-hover table-condensed "> {{-- probé con div y queda mejor con tabla :-\ --}}

                    @foreach($hecho->rel_responsabilidad as $responsabilidad)
                        <tr>
                            <td>
                                {!! $responsabilidad->descripcion->nombre !!}
                            </td>
                            <td>
                                {!! $responsabilidad->descripcion->detalle !!}
                            </td>
                            <td>
                                {!! Form::open(['action' => ['hecho_responsabilidadController@quitar', $responsabilidad->id_hecho_responsabilidad]]) !!}
                                <button type="submit"  class="btn btn-danger btn-sm" onclick = "return confirm('Seguro?')">Quitar</button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
            <div class="clearfix"></div>
                {!! Form::model($hecho, ['route' => ['hechos.update', $hecho->id_hecho], 'method' => 'patch']) !!}



                {!! Form::close() !!}

        </div>
        <div class="box-footer no-padding">
            <div class="bg-gray">
                @include('hechos.p_agregar_responsabilidad')
            </div>
            <div class="bg-white" style="margin-top: 5px">
                <div class="form-group col-sm-12 text-center">
                    @include('controles.radio_si_no_div', ['control_control' => 'id_identifica_pri'
                                                   ,'control_default' => $hecho->fmt_id_identifica_pri
                                                   ,'control_div' => 'div_pri'

                                                   ,'control_texto'=>"¿identifica algún presunto responsable individual?"])
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

@push("js")
    <script>
        $(function() {
            var si = $('#id_identifica_pri_1').iCheck('update')[0].checked;
            if(si) {
                $("#id_identifica_pri_2").attr("disabled", true);
                $("#id_identifica_pri_1").attr("disabled", true);
            }

        });
    </script>

@endpush