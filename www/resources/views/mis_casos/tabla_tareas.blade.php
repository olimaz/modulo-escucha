@php($listado = $misCasos->rel_tareas()->where('id_activo',1)->get() )

<div class="box box-info ">
    <div class="box-body no-padding table-responsive">
        <table class="table table-striped table-hover">
            @foreach($listado as $item)
                <tr>
                    @can('sistema-abierto')
                    <td width="50px">

                        {!! Form::open(['action' => ['mis_casos_tareasController@update',$item->id_mis_casos_tareas], 'id'=>'frm_'.$item->id_mis_casos_tareas] ) !!}
                        <label class="radio-inline icheck icheck_submit">
                            <input type="checkbox" name='realizado' class="flat-green" {{ $item->realizado==1 ? "checked" : "" }} {{ in_array($misCasos->privilegios,[1,5]) ? " " : "disabled" }} >
                        </label>
                        {!! Form::close() !!}

                    </td>
                    @endcan
                    <td>
                        @if($item->realizado==1)
                            <del>
                                {{ $item->descripcion }}
                            </del>
                        @else
                            {{ $item->descripcion }}
                        @endif
                    </td>
                    @can('sistema-abierto')
                    @if(in_array($misCasos->privilegios,[1,5]))
                        <td width="50px">
                            {!! Form::open(['action' => ['mis_casos_tareasController@destroy',$item->id_mis_casos_tareas], 'id'=>'frm_'.$item->id_mis_casos_tareas] ) !!}
                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar esta tarea" data-toggle="tooltip" onclick="return confirm('Esta segura?')"><i class="fa fa-trash-o"></i></button>
                            {!! Form::close() !!}
                        </td>
                    @endif
                    @endcan
                </tr>
            @endforeach

        </table>
    </div>
    <div class="box-footer">
        @can('sistema-abierto')
        @if(in_array($misCasos->privilegios,[1,5]))
            {!! Form::open(['action' => 'mis_casos_tareasController@store']) !!}
                <input type="hidden" name="id_mis_casos" value="{{ $misCasos->id_mis_casos }}">
                <div class="col-xs-12">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Nueva tarea" name="descripcion" required>
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="submit">Crear tarea</button>
                        </span>
                    </div>
                </div>

            {!! Form::close() !!}
        @endif
        @endcan
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function(){
            $('.icheck').iCheck({
                checkboxClass: 'iradio_square-green',
                radioClass: 'iradio_square-green',
                increaseArea: '20%' // optional
            });
            $('.icheck_submit').on('ifChanged', function(event){
                //alert(event.type + ' callback');
                //console.log();
                $(this.closest('form').submit());
            });

            //$('.icheck').on('ifChanged', this.closest("form").submit());
        });
    </script>

@endpush