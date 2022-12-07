@extends("layouts.app")
@section('title', 'Reclasificador')
@section('content_header')
    <h1>Reclasificador de opciones <small>catálogos del sistema.</small></h1>
@stop


@section("content")
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Modificación masiva de las boletas</h3>
            </div>
            <div class="box-body">
                {!! Form::open( ['url' => "#", 'method'=>'GET'])  !!}
                <div class="col-xs-12">
                    <div class="form-group">
                        {!! Form::label('id_cat',"Parámetro") !!}
                        {!! Form::select('id_cat', $catalogos, $id_cat, ["class"=>"form-control","onchange"=>"submit()"]) !!}
                    </div>
                </div>
                @if($accion==0)
                    <div class="col-xs-6">
                        @include('controles.catalogo_completo', ['chivo_control' => 'quitar'
                                                               ,'chivo_id_cat'=>$id_cat
                                                               , 'chivo_default'=>null
                                                               ,'chivo_texto'=>'Quitar esta opción:'
                                                               ])

                    </div>
                    <div class="col-xs-6">
                        @include('controles.catalogo_completo', ['chivo_control' => 'poner'
                                                               ,'chivo_id_cat'=>$id_cat
                                                               , 'chivo_default'=>null
                                                               ,'chivo_texto'=>'En su lugar, utilizar esta opción:'
                                                               ])

                    </div>
                @endif
                <div class="col-xs-12 text-center">
                    @if($accion==0)
                        <button type="submit" name="accion" value="1" class="btn btn-success">Evaluar cambio</button>
                    @elseif($accion==1)
                        <h3>Atención:</h3>
                        <p>Se removerá <span class="text-danger text-bold"> {{ App\Models\gestion\cat_item::find($quitar)->descrip_item }}</span>
                            y en su lugar se colocará  <span class="text-success text-bold">{{ App\Models\gestion\cat_item::find($poner)->descrip_item }}</span>.
                         En el proceso se afectará a <span class="text-primary text-bold">{{ number_format($conteo,0) }}</span> boletas.</p>

                        <p><span class="text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Este cambio es irreversible, proceda con cuidado. <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span></p>
                        <div class="row">
                            <input type="hidden" name="quitar" value="{{ $quitar }}">
                            <input type="hidden" name="poner" value="{{ $poner }}">
                            <button type="submit" name="accion" value="2" class="btn btn-warning"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Aplicar cambio</button>
                            <button type="submit" name="accion" value="0" class="btn btn-default">Cancelar</button>

                        </div>
                    @elseif($accion==2)
                       <h4>Cambio aplicado.</h4>
                        <p>Se sustituyó <span class="text-danger text-bold"> {{ App\Models\gestion\cat_item::find($quitar)->descrip_item }}</span>
                            y en su lugar se colocó  <span class="text-success text-bold">{{ App\Models\gestion\cat_item::find($poner)->descrip_item }}</span>.
                       <p><span class="text-primary text-bold">{{ number_format($conteo,0) }}</span> boletas modificadas.</p>
                        <button type="submit" name="accion" value="0" class="btn btn-primary">Continuar</button>
                    @endif
                </div>


                {!! Form::close() !!}

            </div>
        </div>
    </div>


@endsection
