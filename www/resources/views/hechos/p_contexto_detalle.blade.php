@if(count($hecho->rel_contexto)>0)
        <ol>
            <li>Motivos específicos por los cuales cree que ocurrieron los hechos de violencia
                <ul>
                    @foreach($hecho->arreglo_contexto_txt(127) as $id=>$txt)
                        <li>{{$txt}}</li>
                    @endforeach
                </ul>
            </li>
            <li>Contexto de control territorial y/o de la población
                <ul>
                    @foreach($hecho->arreglo_contexto_txt(128) as $id=>$txt)
                        <li>{{$txt}}</li>
                    @endforeach
                </ul>
            </li>
            <li>Si los hechos ocurrieron en lugares públicos, indique si dicho espacio es significativo para
                <ul>
                    @foreach($hecho->arreglo_contexto_txt(129) as $id=>$txt)
                        <li>{{$txt}}</li>
                    @endforeach
                </ul>
            </li>
            <li>Factores externos que influenciaron los hechos
                <ul>
                    @foreach($hecho->arreglo_contexto_txt(130) as $id=>$txt)
                        <li>{{$txt}}</li>
                    @endforeach
                </ul>
            </li>
            <li>La persona entrevistada considera que estos hechos de violencia beneficiaron a
                <ul>
                    @foreach($hecho->arreglo_contexto_txt(131) as $id=>$txt)
                        <li>{{$txt}}</li>
                    @endforeach
                </ul>
            </li>
        </ol>
@else
    <div class="text-yellow text-center">
        <h4><i class="icon fa fa-warning"></i> Atención</h4>
        No se ha diligenciado esta sección
    </div>
@endif
