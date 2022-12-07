<table class="table table-responsive table-condensed table-hover" id="entrevistadors-table">
    <thead>
    <tr>
        <th title="Número de entrevistador asignado" data-toggle="tooltip">#E.</th>
        <th>Correo</th>
        <th>Nombre</th>

        <th>Privilegios</th>

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

            <td> @if(!empty($entrevistador->username))
                    {!! $entrevistador->username !!}
                @else
                    {!! $entrevistador->fmt_correo !!}
                @endif
            </td>


            <td>{!! $entrevistador->fmt_nombre !!}</td>

            <td>{!! $entrevistador->fmt_id_nivel !!}</td>


            <td>

                {{-- Editar --}}
                @if(Gate::allows('nivel-1'))
                    @if($entrevistador->id_entrevistador <> \Auth::user()->id_entrevistador)
                        <a class="btn btn-default btn-sm" href="{{ action('entrevistadorController@edit',$entrevistador->id_entrevistador) }}" ><i class="fa fa-edit" aria-hidden="true"></i> Editar</a>
                    @endif
                    {{-- Impersonalizar --}}
                    @if(!\Auth::user()->isImpersonating())
                        @if($entrevistador->id_entrevistador <> \Auth::user()->id_entrevistador)
                            @if($entrevistador->id_nivel <> 199)
                                <a class="btn btn-default btn-sm" title="Ver el sistema como este usuario" data-toggle="tooltip" href="{{ action('entrevistadorController@como_otro',$entrevistador->id_entrevistador) }}" ><i class="fa fa-user-secret" aria-hidden="true"></i> </a>
                            @endif
                        @endif
                    @endif
                @endif

                @if(Gate::allows('nivel-1'))

                @endif

            </td>

        </tr>
    @endforeach
    </tbody>
</table>