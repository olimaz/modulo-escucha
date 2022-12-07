@php($info = $expediente->conteo_impactos())

<table class="table table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <th>Sección</th>
            <th class="text-center">Opciones seleccionadas</th>
        </tr>
    </thead>
    <tbody>            
            @php($titulo = ($expediente->tipo()=='individual' ? 'Impactos individuales' : 'Impactos sobre las comunidades'))

            <tr>
                <td> {{$titulo}}</td>
                <td class="text-center">{{ $info->i_individuales  }}</td>
            </tr>

            <tr>
                <td> Impactos relacionales</td>
                <td class="text-center">{{ $info->i_relacionales  }}</td>
            </tr>
            <tr>
                <td> Impactos colectivos</td>
                <td class="text-center">{{ $info->i_colectivos  }}</td>
            </tr>
            <tr>
                <td> Afrentamiento individual</td>
                <td class="text-center">{{ $info->a_individual  }}</td>
            </tr>
            @if ($expediente->tipo()=='individual')
            <tr>
                <td> Afrentamiento familiar</td>
                <td class="text-center">{{ $info->a_familiar  }}</td>
            </tr>
            @endif
            <tr>
                <td> Afrentamiento colectivo</td>
                <td class="text-center">{{ $info->a_colectivo  }}</td>
            </tr>
            <tr>
                <td>Autoridades / entidades ante quienes puso en conocimiento</td>
                <td class="text-center">{{ $info->denuncia  }}</td>
            </tr>
            <tr>
                <td>Medidas de reparación recibidas</td>
                <td class="text-center">{{ $info->reparacion  }}</td>
            </tr>

    </tbody>
</table>