<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Documento identididad</th>
                <th>Sexo</th>
                <th>Lugar de nacimiento</th>
                <th>Estado de revisión</th>
                <th>Entrevista</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($personas_duplicadas as $p)

                <tr>
                    <td>{{$p->nombre}}</td>
                    <td>{{$p->apellido}}</td>
                    <td>{!!$p->DocumentoIdentidad !!}</td>
                    <td>{!!$p->sexo !!}</td>
                    <td>{!!$p->fmt_id_lugar_nacimiento !!}</td>
                    <td>{!!($p->estado == true  ? 'Pendiente': '')  !!}</td>
                    <td>
                        <a href="{!! route('entrevistaindividual.fichas', [$p->id_e_ind_fvt]) !!}"  class='btn btn-outline-default' target="_blank">
                            {{$p->fmt_id_e_ind_fvt}}
                        </a>                        
                    </td>
                </tr>            
            @endforeach

        </tbody>
    </table>
</div>
