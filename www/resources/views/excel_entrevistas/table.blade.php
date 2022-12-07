<table class="table table-responsive" id="excelEntrevistas-table">
    <thead>
        <tr>
            <th>Correlativo</th>
        <th>Codigo Entrevista</th>
        <th>Codigo Entrevistador</th>
        <th>Macroterritorio Id</th>
        <th>Macroterritorio Txt</th>
        <th>Territorio Id</th>
        <th>Territorio Txt</th>
        <th>Entrevista Fecha</th>
        <th>Entrevista Lugar N1 Codigo</th>
        <th>Entrevista Lugar N1 Txt</th>
        <th>Entrevista Lugar N2 Codigo</th>
        <th>Entrevista Lugar N2 Txt</th>
        <th>Entrevista Lugar N3 Codigo</th>
        <th>Entrevista Lugar N3 Txt</th>
        <th>Titulo</th>
        <th>Hechos Lugar N1 Codigo</th>
        <th>Hechos Lugar N1 Txt</th>
        <th>Hechos Lugar N2 Codigo</th>
        <th>Hechos Lugar N2 Txt</th>
        <th>Hechos Lugar N3 Codigo</th>
        <th>Hechos Lugar N3 Txt</th>
        <th>Hechos Del</th>
        <th>Hechos Al</th>
        <th>Anotaciones</th>
        <th>Aa Paramilitar</th>
        <th>Aa Guerrilla</th>
        <th>Aa Fuerza Publica</th>
        <th>Aa Terceros Civiles</th>
        <th>Aa Otro</th>
        <th>Viol Homicidio</th>
        <th>Viol Atentado Vida</th>
        <th>Viol Amenaza Vida</th>
        <th>Viol Desaparicion F</th>
        <th>Viol Tortura</th>
        <th>Viol Violencia Sexual</th>
        <th>Viol Esclavitud</th>
        <th>Viol Detencion Arbitraria</th>
        <th>Viol Secuestro</th>
        <th>Viol Confinamiento</th>
        <th>Viol Pillaje</th>
        <th>Viol Extorsion</th>
        <th>Viol Ataque Bien Protegido</th>
        <th>Viol Ataque Indiscriminado</th>
        <th>Viol Despojo Tierras</th>
        <th>Viol Desplazamiento Forzado</th>
        <th>Viol Exilio</th>
        <th>I Objetivo Esclarecimiento</th>
        <th>I Objetivo Reconocimiento</th>
        <th>I Objetivo Convivencia</th>
        <th>I Objetivo No Repeticion</th>
        <th>I Enfoque Genero</th>
        <th>I Enfoque Psicosocial</th>
        <th>I Enfoque Curso Vida</th>
        <th>I Direccion Investigacion</th>
        <th>I Direccion Territorios</th>
        <th>I Direccion Etnica</th>
        <th>I Comisionados</th>
        <th>I Estrategia Arte</th>
        <th>I Estrategia Comunicacion</th>
        <th>I Estrategia Participacion</th>
        <th>I Estrategia Pedagogia</th>
        <th>I Grupo Acceso Informacion</th>
        <th>I Presidencia</th>
        <th>I Otra</th>
        <th>I Enlace</th>
        <th>I Sistema Informacion</th>
        <th>Mandato 01</th>
        <th>Mandato 02</th>
        <th>Mandato 03</th>
        <th>Mandato 04</th>
        <th>Mandato 05</th>
        <th>Mandato 06</th>
        <th>Mandato 07</th>
        <th>Mandato 08</th>
        <th>Mandato 09</th>
        <th>Mandato 10</th>
        <th>Mandato 11</th>
        <th>Mandato 12</th>
        <th>Mandato 13</th>
        <th>Dinamica 1</th>
        <th>Dinamica 2</th>
        <th>Dinamica 3</th>
        <th>A Consentimiento</th>
        <th>A Audio</th>
        <th>A Ficha Corta</th>
        <th>A Ficha Larga</th>
        <th>A Otros</th>
        <th>A Transcripcion Preliminar</th>
        <th>A Transcripcion Final</th>
        <th>A Retroalimentacion</th>
        <th>Created At</th>
        <th>Updated At</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($excelEntrevistas as $excelEntrevista)
        <tr>
            <td>{!! $excelEntrevista->correlativo !!}</td>
            <td>{!! $excelEntrevista->codigo_entrevista !!}</td>
            <td>{!! $excelEntrevista->codigo_entrevistador !!}</td>
            <td>{!! $excelEntrevista->macroterritorio_id !!}</td>
            <td>{!! $excelEntrevista->macroterritorio_txt !!}</td>
            <td>{!! $excelEntrevista->territorio_id !!}</td>
            <td>{!! $excelEntrevista->territorio_txt !!}</td>
            <td>{!! $excelEntrevista->entrevista_fecha !!}</td>
            <td>{!! $excelEntrevista->entrevista_lugar_n1_codigo !!}</td>
            <td>{!! $excelEntrevista->entrevista_lugar_n1_txt !!}</td>
            <td>{!! $excelEntrevista->entrevista_lugar_n2_codigo !!}</td>
            <td>{!! $excelEntrevista->entrevista_lugar_n2_txt !!}</td>
            <td>{!! $excelEntrevista->entrevista_lugar_n3_codigo !!}</td>
            <td>{!! $excelEntrevista->entrevista_lugar_n3_txt !!}</td>
            <td>{!! $excelEntrevista->titulo !!}</td>
            <td>{!! $excelEntrevista->hechos_lugar_n1_codigo !!}</td>
            <td>{!! $excelEntrevista->hechos_lugar_n1_txt !!}</td>
            <td>{!! $excelEntrevista->hechos_lugar_n2_codigo !!}</td>
            <td>{!! $excelEntrevista->hechos_lugar_n2_txt !!}</td>
            <td>{!! $excelEntrevista->hechos_lugar_n3_codigo !!}</td>
            <td>{!! $excelEntrevista->hechos_lugar_n3_txt !!}</td>
            <td>{!! $excelEntrevista->hechos_del !!}</td>
            <td>{!! $excelEntrevista->hechos_al !!}</td>
            <td>{!! $excelEntrevista->anotaciones !!}</td>
            <td>{!! $excelEntrevista->aa_paramilitar !!}</td>
            <td>{!! $excelEntrevista->aa_guerrilla !!}</td>
            <td>{!! $excelEntrevista->aa_fuerza_publica !!}</td>
            <td>{!! $excelEntrevista->aa_terceros_civiles !!}</td>
            <td>{!! $excelEntrevista->aa_otro !!}</td>
            <td>{!! $excelEntrevista->viol_homicidio !!}</td>
            <td>{!! $excelEntrevista->viol_atentado_vida !!}</td>
            <td>{!! $excelEntrevista->viol_amenaza_vida !!}</td>
            <td>{!! $excelEntrevista->viol_desaparicion_f !!}</td>
            <td>{!! $excelEntrevista->viol_tortura !!}</td>
            <td>{!! $excelEntrevista->viol_violencia_sexual !!}</td>
            <td>{!! $excelEntrevista->viol_esclavitud !!}</td>
            <td>{!! $excelEntrevista->viol_detencion_arbitraria !!}</td>
            <td>{!! $excelEntrevista->viol_secuestro !!}</td>
            <td>{!! $excelEntrevista->viol_confinamiento !!}</td>
            <td>{!! $excelEntrevista->viol_pillaje !!}</td>
            <td>{!! $excelEntrevista->viol_extorsion !!}</td>
            <td>{!! $excelEntrevista->viol_ataque_bien_protegido !!}</td>
            <td>{!! $excelEntrevista->viol_ataque_indiscriminado !!}</td>
            <td>{!! $excelEntrevista->viol_despojo_tierras !!}</td>
            <td>{!! $excelEntrevista->viol_desplazamiento_forzado !!}</td>
            <td>{!! $excelEntrevista->viol_exilio !!}</td>
            <td>{!! $excelEntrevista->i_objetivo_esclarecimiento !!}</td>
            <td>{!! $excelEntrevista->i_objetivo_reconocimiento !!}</td>
            <td>{!! $excelEntrevista->i_objetivo_convivencia !!}</td>
            <td>{!! $excelEntrevista->i_objetivo_no_repeticion !!}</td>
            <td>{!! $excelEntrevista->i_enfoque_genero !!}</td>
            <td>{!! $excelEntrevista->i_enfoque_psicosocial !!}</td>
            <td>{!! $excelEntrevista->i_enfoque_curso_vida !!}</td>
            <td>{!! $excelEntrevista->i_direccion_investigacion !!}</td>
            <td>{!! $excelEntrevista->i_direccion_territorios !!}</td>
            <td>{!! $excelEntrevista->i_direccion_etnica !!}</td>
            <td>{!! $excelEntrevista->i_comisionados !!}</td>
            <td>{!! $excelEntrevista->i_estrategia_arte !!}</td>
            <td>{!! $excelEntrevista->i_estrategia_comunicacion !!}</td>
            <td>{!! $excelEntrevista->i_estrategia_participacion !!}</td>
            <td>{!! $excelEntrevista->i_estrategia_pedagogia !!}</td>
            <td>{!! $excelEntrevista->i_grupo_acceso_informacion !!}</td>
            <td>{!! $excelEntrevista->i_presidencia !!}</td>
            <td>{!! $excelEntrevista->i_otra !!}</td>
            <td>{!! $excelEntrevista->i_enlace !!}</td>
            <td>{!! $excelEntrevista->i_sistema_informacion !!}</td>
            <td>{!! $excelEntrevista->mandato_01 !!}</td>
            <td>{!! $excelEntrevista->mandato_02 !!}</td>
            <td>{!! $excelEntrevista->mandato_03 !!}</td>
            <td>{!! $excelEntrevista->mandato_04 !!}</td>
            <td>{!! $excelEntrevista->mandato_05 !!}</td>
            <td>{!! $excelEntrevista->mandato_06 !!}</td>
            <td>{!! $excelEntrevista->mandato_07 !!}</td>
            <td>{!! $excelEntrevista->mandato_08 !!}</td>
            <td>{!! $excelEntrevista->mandato_09 !!}</td>
            <td>{!! $excelEntrevista->mandato_10 !!}</td>
            <td>{!! $excelEntrevista->mandato_11 !!}</td>
            <td>{!! $excelEntrevista->mandato_12 !!}</td>
            <td>{!! $excelEntrevista->mandato_13 !!}</td>
            <td>{!! $excelEntrevista->dinamica_1 !!}</td>
            <td>{!! $excelEntrevista->dinamica_2 !!}</td>
            <td>{!! $excelEntrevista->dinamica_3 !!}</td>
            <td>{!! $excelEntrevista->a_consentimiento !!}</td>
            <td>{!! $excelEntrevista->a_audio !!}</td>
            <td>{!! $excelEntrevista->a_ficha_corta !!}</td>
            <td>{!! $excelEntrevista->a_ficha_larga !!}</td>
            <td>{!! $excelEntrevista->a_otros !!}</td>
            <td>{!! $excelEntrevista->a_transcripcion_preliminar !!}</td>
            <td>{!! $excelEntrevista->a_transcripcion_final !!}</td>
            <td>{!! $excelEntrevista->a_retroalimentacion !!}</td>
            <td>{!! $excelEntrevista->created_at !!}</td>
            <td>{!! $excelEntrevista->updated_at !!}</td>
            <td>
                {!! Form::open(['route' => ['excelEntrevistas.destroy', $excelEntrevista->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('excelEntrevistas.show', [$excelEntrevista->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('excelEntrevistas.edit', [$excelEntrevista->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>