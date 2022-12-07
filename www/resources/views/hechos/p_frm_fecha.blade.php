<div class="clearfix"></div>
<div class="col-xs-12">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">
                1. Fecha y lugar de los hechos
            </h3>
        </div>
        <div class="box-body">
            {!! Form::model($hecho, ['route' => ['hechos.update', $hecho->id_hecho], 'method' => 'patch', 'id'=>'frm_abc_hecho']) !!}

            {{-- Usado por el botón grabar y finalizar--}}
            <input type="hidden" name="fin" id="fin" value="0">

            @include('hechos.fields_2')

            {!! Form::close() !!}

        </div>

    </div>



</div>
<div class="clearfix"></div>