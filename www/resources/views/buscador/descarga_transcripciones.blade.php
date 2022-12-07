@extends('layouts.app')
@section('content')
    <div class="row container">
        <div class="col-sm-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title text-primary">Descarga de transcripciones</h1>
                </div>
                <div class="box-body">

                    @include("partials.texto_descarga")
                </div>
                <div class="box-footer">
                    <div class="col-xs-6 text-right">
                        <label>
                            <input type="checkbox" id="estoy_acuerdo" > He leído el texto y estoy de acuerdo
                        </label>
                    </div>
                    <div class="col-xs-6 text-left">
                        {!! Form::open(['action' => 'statController@descargar_transcripciones']) !!}
                            @foreach($request->all() as $var=>$val)
                                @if(is_array($val))
                                    @foreach($val as $val2)
                                        <input type="hidden" name="{{$var}}[]" value="{{$val2}}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="{{$var}}" value="{{$val}}">
                                @endif

                            @endforeach
                            <button  class="btn btn-primary"  id="btn_acepto" type="submit"  disabled>Descargar</button>
                            <a href="#" onclick="window.history.back()" class="btn btn-default">Cancelar</a>
                        {!! Form::close() !!}




                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section("js")
    <script>
        $(function() {
            $('#estoy_acuerdo').click(function() {
                if ($(this).is(':checked')) {
                    $('#btn_acepto').removeAttr('disabled');

                } else {
                    $('#btn_acepto').attr('disabled', 'disabled');
                }
            });
        });

    </script>

@endsection

