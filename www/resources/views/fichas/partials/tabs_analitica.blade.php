<div class="card card-gray-dark card-tabs">
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="tabs-analitica" role="tablist">
            <li class="nav-item " id="t_violencia">
                <a href="#violencia" class="nav-link  " id="a_violencia"  data-toggle="pill" role="tab" aria-controls="a_violencia" >Violencia</a>
            </li>
            <li class="nav-item" id="t_victima">
                <a href="#victima" class="nav-link " id="a_victima"  data-toggle="pill" role="tab" aria-controls="a_victima" >Víctimas</a>
            </li>
            <li class="nav-item" id="t_pri">
                <a href="#pri"  class="nav-link " id="a_pri"  data-toggle="pill" role="tab" aria-controls="a_pri" >Presunto responsable</a>
            </li>

            <li class="nav-item" id="t_contexto">
                <a href="#contexto" class="nav-link " id="a_contexto"  data-toggle="pill" role="tab" aria-controls="a_contexto" >Dinámicas y contexto</a>
            </li>
            <li class="nav-item" id="t_impactos">
                <a href="#impactos" class="nav-link " id="a_impactos" data-toggle="pill" role="tab" aria-controls="a_impactos" >Impactos y afrontamiento</a>
            </li>
            <li class="nav-item" id="t_exilio">
                <a href="#exilio" class="nav-link " id="a_exilio"  data-toggle="pill" role="tab" aria-controls="a_exilio" >Exilio</a>
            </li>
            <li class="nav-item" id="t_concurrencia">
                <a href="#concurrencia" class="nav-link " id="a_concurrencia"  data-toggle="pill" role="tab" aria-controls="a_concurrencia" >Concurrencia</a>
            </li>


        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">

            <div class="tab-pane fade  " id="victima" style=" min-height: 300px;">
                @include('fichas.stats.victima')
                <div class="clearfix"></div>
            </div>

            <div class="tab-pane fade" id="pri" style=" min-height: 300px;">
                @include('fichas.stats.pri')
                <div class="clearfix"></div>
            </div>

            <div class="tab-pane fade" id="violencia" style=" min-height: 300px;">
                @include('fichas.stats.violencia')
                <div class="clearfix"></div>
            </div>
            <div class="tab-pane fade" id="contexto" style=" min-height: 300px;">
                @include('fichas.stats.contexto')
                <div class="clearfix"></div>
            </div>

            <div class="tab-pane fade" id="impactos" style=" min-height: 300px;">
                @include('fichas.stats.impactos')
                <div class="clearfix"></div>
            </div>

            <div class="tab-pane fade" id="exilio" style=" min-height: 300px;">
                @include('fichas.stats.exilio')
                <div class="clearfix"></div>
            </div>
            <div class="tab-pane fade" id="concurrencia" style=" min-height: 300px;">
                @include('fichas.stats.concurrencia')
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- /.card -->
</div>