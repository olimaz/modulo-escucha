<table class="table table-responsive table-condensed table-hover" id="entrevistadors-table">
    <thead>
        <tr>
            <th title="Número de entrevistador asignado" data-toggle="tooltip">#E.</th>
            {{--
            <th>Correo / usuario</th>
            --}}
            <th>Nombre</th>
            <th>Macroterritorio</th>
            <th>Territorio</th>
            <th>Privilegios</th>
            <th data-toggle="tooltip" data-tooltip="Aplican restricciones de investigador">Investigación</th>
            <th>Grupo</th>
            <th title="Entrevistas a víctimas" data-toggle="tooltip">E. VI.</th>
            <th title="Entrevistas a actores armados" data-toggle="tooltip">E. AA.</th>
            <th title="Entrevistas a terceros civiles" data-toggle="tooltip">E. TC.</th>
            <th title="Entrevistas colectivas" data-toggle="tooltip">E. CO.</th>
            <th title="Entrevistas a sujetos colectivos" data-toggle="tooltip">E. EE.</th>
            <th title="Entrevistas a profundidad" data-toggle="tooltip">E. PR.</th>
            <th title="Diagnósticos comunitarios" data-toggle="tooltip">D.C.</th>
            <th title="Historias de vida" data-toggle="tooltip">H.V.</th>
            <th></th>




        </tr>
    </thead>
    <tbody>
    @foreach($entrevistadors as $entrevistador)

        <tr>
            <td>
                <a href="{{ action('entrevistadorController@show',$entrevistador->id_entrevistador) }}">
                {!! $entrevistador->numero_entrevistador !!}
                </a>
            </td>
            {{--
            <td> @if(!empty($entrevistador->username))
                    {!! $entrevistador->username !!}
                 @else
                    {!! $entrevistador->fmt_correo !!}
                 @endif
            </td>
            --}}

            <td>{!! $entrevistador->fmt_nombre !!}</td>
            <td>{!! $entrevistador->fmt_id_macroterritorio !!}</td>
            <td>{!! $entrevistador->fmt_id_territorio !!}</td>
            <td>{!! $entrevistador->fmt_id_nivel !!}</td>
            <td class="text-center">{!! $entrevistador->fmt_investigador !!}</td>
            <td>{!! $entrevistador->fmt_grupo !!}</td>
            <td class="text-center">
                @if($entrevistador->conteo_entrevistas > 0)
                    <a class="btn btn-default" href="{!! action('entrevista_individualController@index').'?id_entrevistador='.$entrevistador->id_entrevistador !!}">{!! $entrevistador->conteo_entrevistas !!}</a>
                @else
                    {{ $entrevistador->conteo_entrevistas }}
                @endif
            </td>
            <td class="text-center">
                @if($entrevistador->conteo_entrevistas_aa > 0)
                    <a class="btn btn-default" href="{!! action('entrevista_individualController@index').'?id_entrevistador='.$entrevistador->id_entrevistador."&id_subserie=".config('expedientes.aa') !!}">{!! $entrevistador->conteo_entrevistas_aa !!}</a>
                @else
                    0
                @endif
            </td>
            <td class="text-center">
                @if($entrevistador->conteo_entrevistas_tc > 0)
                    <a class="btn btn-default" href="{!! action('entrevista_individualController@index').'?id_entrevistador='.$entrevistador->id_entrevistador."&id_subserie=".config('expedientes.tc') !!}">{!! $entrevistador->conteo_entrevistas_tc !!}</a>
                @else
                    0
                @endif
            </td>
            <td class="text-center">
                @if($entrevistador->conteo_entrevistas_co > 0)
                    <a class="btn btn-default" href="{!! action('entrevista_colectivaController@index').'?id_entrevistador='.$entrevistador->id_entrevistador !!}">
                        {!! $entrevistador->conteo_entrevistas_co !!}
                    </a>
                @else
                    0
                @endif
            </td>
            <td class="text-center">
                @if($entrevistador->conteo_entrevistas_ee > 0)
                    <a class="btn btn-default" href="{!! action('entrevista_etnicaController@index').'?id_entrevistador='.$entrevistador->id_entrevistador !!}">
                        {!! $entrevistador->conteo_entrevistas_ee !!}
                    </a>
                @else
                    0
                @endif
            </td>
            <td class="text-center">
                @if($entrevistador->conteo_entrevistas_pr > 0)
                    <a class="btn btn-default" href="{!! action('entrevista_profundidadController@index').'?id_entrevistador='.$entrevistador->id_entrevistador !!}">
                        {!! $entrevistador->conteo_entrevistas_pr !!}
                    </a>
                @else
                    0
                @endif
            </td>
            <td class="text-center">
                @if($entrevistador->conteo_entrevistas_dc > 0)
                    <a class="btn btn-default" href="{!! action('diagnostico_comunitarioController@index').'?id_entrevistador='.$entrevistador->id_entrevistador !!}">
                        {!! $entrevistador->conteo_entrevistas_dc !!}
                    </a>
                @else
                    0
                @endif
            </td>
            <td class="text-center">
                @if($entrevistador->conteo_entrevistas_hv > 0)
                    <a class="btn btn-default" href="{!! action('historia_vidaController@index').'?id_entrevistador='.$entrevistador->id_entrevistador !!}">
                        {!! $entrevistador->conteo_entrevistas_hv !!}
                    </a>
                @else
                    0
                @endif
            </td>

            <td>
                @if(Gate::allows('nivel-1'))
                    @if($entrevistador->id_entrevistador <> \Auth::user()->id_entrevistador)
                        @if(\Auth::user()->id_nivel <= $entrevistador->id_nivel )

                                <a class="btn btn-default btn-sm" href="{{ action('entrevistadorController@frm_nivel',$entrevistador->id_entrevistador) }}" >Cambiar perfil</a>

                        @endif
                    @endif
                @endif
                @if(Gate::allows('nivel-1'))
                    @if(!\Auth::user()->isImpersonating())
                        @if($entrevistador->id_entrevistador <> \Auth::user()->id_entrevistador)
                                <a class="btn btn-default btn-sm" title="Ver el sistema como este usuario" data-toggle="tooltip" href="{{ action('entrevistadorController@como_otro',$entrevistador->id_entrevistador) }}" ><i class="fa fa-user-secret" aria-hidden="true"></i> </a>
                        @endif
                    @endif
                @endif
            </td>

        </tr>
    @endforeach
    </tbody>
</table>