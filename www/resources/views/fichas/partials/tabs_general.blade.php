{{-- TABS general--}}

    <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="tabs-gral" role="tablist">
                <li class="nav-item" id="t_procesamiento">
                    <a href="#g1" class="nav-link active" id="a_g1"  data-toggle="pill" role="tab" aria-controls="c_g1" >Procesamiento</a>
                </li>
                <li class="nav-item" id="t_entrevistada">
                    <a href="#g2"class="nav-link " id="a_g2"  data-toggle="pill" role="tab" aria-controls="c_g2" >Persona entrevistada</a>
                </li>
                <li class="nav-item" id="t_3">
                    <a href="#g3" class="nav-link " id="a_g3"  data-toggle="pill" role="tab" aria-controls="c_g3" >Datos de violencia</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-gral-tabContent">
                <div class="tab-pane fade show active" id="g1" style="min-height: 300px;">
                    @include('fichas.stats.procesamiento')
                    <div class="clearfix"></div>
                </div>

                <div class="tab-pane  fade " id="g2" style="min-height: 300px;">
                    @include('fichas.stats.entrevistada')
                    <div class="clearfix"></div>
                </div>

                <div class="tab-pane fade " id="g3" style=" min-height: 300px;">
                    @include('fichas.partials.tabs_analitica')
                    <div class="clearfix"></div>
                </div>

            </div>
        </div>
        <!-- /.card -->
    </div>


<div class="w-100"></div>