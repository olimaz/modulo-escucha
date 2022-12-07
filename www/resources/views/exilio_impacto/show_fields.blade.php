<div class="col-sm-6">
    <label>Impactos en la primera salida / primera llegada</label>
    @if(count($exilio->arreglo_impacto(208)) == 0)
        <p>Sin especificar</p>
    @else
        <ul>
            @foreach($exilio->arreglo_impacto(208) as $id)
                <li>{{ \App\Models\cat_item::describir($id) }}</li>
            @endforeach
        </ul>
    @endif
</div>
<div class="col-sm-6">
    <label>Afrontamiento en la primera salida / primera llegada</label>
    @if(count($exilio->arreglo_impacto(209)) == 0)
        <p>Sin especificar</p>
    @else
        <ul>
            @foreach($exilio->arreglo_impacto(209) as $id)
                <li>{{ \App\Models\cat_item::describir($id) }}</li>
            @endforeach
        </ul>
    @endif
</div>
<div class="clearfix"></div>
<div class="col-sm-6">
    <label>Impactos a largo plazo del exilio</label>
    @if(count($exilio->arreglo_impacto(210)) == 0)
        <p>Sin especificar</p>
    @else
        <ul>
            @foreach($exilio->arreglo_impacto(210) as $id)
                <li>{{ \App\Models\cat_item::describir($id) }}</li>
            @endforeach
        </ul>
    @endif
</div>
<div class="col-sm-6">
    <label>Afrontameinto en el largo plazo</label>
    @if(count($exilio->arreglo_impacto(211)) == 0)
        <p>Sin especificar</p>
    @else
        <ul>
            @foreach($exilio->arreglo_impacto(211) as $id)
                <li>{{ \App\Models\cat_item::describir($id) }}</li>
            @endforeach
        </ul>
    @endif
</div>