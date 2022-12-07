

<div class="table-responsive">

    <table id="table-result" class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Documento</th>
                <th>Sexo</th>
                <th>Entrevista</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($personas as $p)
                <tr>
                    <td>{{$p->nombre_completo}}</td>
                    <td>{{$p->num_documento}}</td>
                    <td>{{$p->sexo}}</td>
                    <td>
                        <a href="{!! route('entrevistaindividual.fichas', [$p->id_e_ind_fvt]) !!}"  class='btn btn-outline-default' target="_blank">
                            {{$p->fmt_id_e_ind_fvt}}
                        </a>
                    </td>
                    <td class="text-center">                        
                        <a href="#" onclick="vincular_duplicados('{{$p->id_victima}}', '{{$id_e_ind_fvt_nueva}}', '{{$p->id_e_ind_fvt}}');" class='btn btn-success btn-xs'><i class="glyphicon glyphicon-random"></i></a>
                    </td>
                </tr>                
            @endforeach

    Button name
</button>
        </tbody>
    </table>

</div>

<script>
$(document).ready(function() {
    $('#table-result').DataTable();
} );

function vincular_duplicados(victima, ent_nueva, ent_existe) {

    var param = "id_victima="+victima+"&id_e_inv_fvt_nueva="+ent_nueva+"&id_e_inv_fvt_existente="+ent_existe;
    
    $.ajax({
        type:'post',
        url: '{{route('victimas.vincular_duplicado')}}',
        data:param,
        success:function(datos){                                 
        }
    });    

    location.reload();
}
</script>