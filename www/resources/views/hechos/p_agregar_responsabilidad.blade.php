
    <div class="col-sm-12">
        <p class="text-muted">
            Indique el tipo de responsabilidad colectiva mencionada en el relato:
        </p>
    </div>


<div class="row">
    <div class="col-sm-12">
            <div class="form-group col-xs-9">
                @include('controles.tipo_aa', ['control_control' => 'id_tipo_aa'
                            ,'control_texto' => ''
                            ])
            </div>
        <div class="col-xs-3">
            <br><br>
            <button type="button" class="btn btn-default" onclick="agregar_aa()">Agregar</button>
        </div>
    </div>
    <div class="col-sm-12" style="margin-top: -30px">
                <div class="form-group col-xs-9">
                    @include('controles.tipo_tc', ['control_control' => 'id_tipo_tc'
                                ,'control_texto' => ''
                                ])
                </div>
            <div class="col-xs-3">
                <br><br>
                <button type="button" class="btn btn-default" onclick="agregar_tc()">Agregar</button>
            </div>

    </div>
</div>

{{--  MODALES para especificar diferentes datos, según el actor armado o tercero civil --}}


{{-- Grupo paramilitar --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_aa_0101">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_responsabilidadController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Grupo Paramilitar</h4>
            </div>
            <input type="hidden" name="codigo_aa" value="0101">
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    {!! Form::label('aa_nombre_grupo', '¿Cuál grupo?:') !!}
                    {!! Form::text('aa_nombre_grupo', null, ['class' => 'form-control','maxlength'=>190]) !!}
                </div>
                <div class="form-group col-xs-12">
                    {!! Form::label('aa_bloque', 'Bloque:') !!}
                    {!! Form::text('aa_bloque', null, ['class' => 'form-control','maxlength'=>190]) !!}
                </div>
                <div class="form-group col-xs-12">
                    {!! Form::label('aa_frente', 'Frente:') !!}
                    {!! Form::text('aa_frente', null, ['class' => 'form-control','maxlength'=>190]) !!}
                </div>
                <div class="form-group col-xs-12">
                    {!! Form::label('aa_unidad', 'Otra unidad:') !!}
                    {!! Form::text('aa_unidad', null, ['class' => 'form-control','maxlength'=>190]) !!}
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" >Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
        {!! Form::close() !!}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{-- Guerrilla:otro --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_aa_0203">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_responsabilidadController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Guerrilla</h4>
            </div>
            <input type="hidden" name="codigo_aa" value="0203">
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    {!! Form::label('aa_otro_cual', '¿Cuál?:') !!}
                    {!! Form::text('aa_otro_cual', null, ['class' => 'form-control','maxlength'=>190,'required'=>'required']) !!}
                </div>
                <div class="form-group col-xs-12">
                    {!! Form::label('aa_bloque', 'Bloque:') !!}
                    {!! Form::text('aa_bloque', null, ['class' => 'form-control','maxlength'=>190]) !!}
                </div>
                <div class="form-group col-xs-12">
                    {!! Form::label('aa_frente', 'Frente:') !!}
                    {!! Form::text('aa_frente', null, ['class' => 'form-control','maxlength'=>190]) !!}
                </div>
                <div class="form-group col-xs-12">
                    {!! Form::label('aa_unidad', 'Otra unidad:') !!}
                    {!! Form::text('aa_unidad', null, ['class' => 'form-control','maxlength'=>190]) !!}
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" >Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
        {!! Form::close() !!}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{-- Guerrilla --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_aa_02">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_responsabilidadController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Guerrilla</h4>
            </div>
            <input type="hidden" name="codigo_aa" value="02"  id="guerrilla">
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    {!! Form::label('aa_bloque', 'Bloque:') !!}
                    {!! Form::text('aa_bloque', null, ['class' => 'form-control','maxlength'=>190]) !!}
                </div>
                <div class="form-group col-xs-12">
                    {!! Form::label('aa_frente', 'Frente:') !!}
                    {!! Form::text('aa_frente', null, ['class' => 'form-control','maxlength'=>190]) !!}
                </div>
                <div class="form-group col-xs-12">
                    {!! Form::label('aa_unidad', 'Otra unidad:') !!}
                    {!! Form::text('aa_unidad', null, ['class' => 'form-control','maxlength'=>190]) !!}
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" >Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
        {!! Form::close() !!}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


{{-- Fuerza pública --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_aa_03">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_responsabilidadController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Fuerza Pública</h4>
            </div>
            <input type="hidden" name="codigo_aa" value="02" id="fuerza_publica">
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    {!! Form::label('aa_unidad', 'Detalle de batallón, brigada, unidad:') !!}
                    {!! Form::text('aa_unidad', null, ['class' => 'form-control','maxlength'=>190]) !!}
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" >Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
        {!! Form::close() !!}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{-- Otro grupo armado --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_aa_0401">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_responsabilidadController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Otro grupo armado</h4>
            </div>
            <input type="hidden" name="codigo_aa" value="0401" >
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    {!! Form::label('aa_otro_cual', '¿Cuál?:') !!}
                    {!! Form::text('aa_otro_cual', null, ['class' => 'form-control','maxlength'=>190,'required'=>'required']) !!}
                </div>
                <div class="form-group col-xs-12">
                    {!! Form::label('aa_unidad', 'Detalle unidad:') !!}
                    {!! Form::text('aa_unidad', null, ['class' => 'form-control','maxlength'=>190]) !!}
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" >Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
        {!! Form::close() !!}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    {{-- Otro grupo armado --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_aa_0402">
        <div class="modal-dialog " role="document">
            {!! Form::open(['action' => ['hecho_responsabilidadController@agregar']]) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ejército de otro país</h4>
                </div>
                <input type="hidden" name="codigo_aa" value="0402" >
                <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
                <div class="modal-body">
                    <div class="form-group col-xs-12">
                        {!! Form::label('aa_otro_cual', '¿De qué país?:') !!}
                        {!! Form::text('aa_otro_cual', null, ['class' => 'form-control','maxlength'=>190,'required'=>'required']) !!}
                    </div>
                    <div class="form-group col-xs-12">
                        {!! Form::label('aa_unidad', 'Detalle unidad (si aplica):') !!}
                        {!! Form::text('aa_unidad', null, ['class' => 'form-control','maxlength'=>190]) !!}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" >Añadir</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div><!-- /.modal-content -->
            {!! Form::close() !!}
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{-- NS/NR --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_aa_0501">
        <div class="modal-dialog " role="document">
            {!! Form::open(['action' => ['hecho_responsabilidadController@agregar']]) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">No sabe o No responde</h4>
                </div>
                <input type="hidden" name="codigo_aa" value="0501" >
                <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
                <div class="modal-body">
                    <div class="form-group col-xs-12">
                        {!! Form::label('aa_unidad', 'Opcionalmente, puede indicar algún detalle conocido:') !!}
                        {!! Form::text('aa_unidad', null, ['class' => 'form-control','maxlength'=>190]) !!}
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" >Añadir</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div><!-- /.modal-content -->
            {!! Form::close() !!}
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{-- PAramilitar: desconocido--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_aa_0199">
        <div class="modal-dialog " role="document">
            {!! Form::open(['action' => ['hecho_responsabilidadController@agregar']]) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Grupo Paramilitar</h4>
                </div>
                <input type="hidden" name="codigo_aa" value="0199" >
                <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
                <div class="modal-body">
                    <div class="form-group col-xs-12">
                        {!! Form::label('aa_unidad', 'Opcionalmente, puede indicar algún detalle conocido:') !!}
                        {!! Form::text('aa_unidad', null, ['class' => 'form-control','maxlength'=>190]) !!}
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" >Añadir</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div><!-- /.modal-content -->
            {!! Form::close() !!}
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    {{-- Guerrilla: desconocido--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_aa_0299">
        <div class="modal-dialog " role="document">
            {!! Form::open(['action' => ['hecho_responsabilidadController@agregar']]) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Guerrilla</h4>
                </div>
                <input type="hidden" name="codigo_aa" value="0299" >
                <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
                <div class="modal-body">
                    <div class="form-group col-xs-12">
                        {!! Form::label('aa_unidad', 'Opcionalmente, puede indicar algún detalle conocido:') !!}
                        {!! Form::text('aa_unidad', null, ['class' => 'form-control','maxlength'=>190]) !!}
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" >Añadir</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div><!-- /.modal-content -->
            {!! Form::close() !!}
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


{{-- Terceros civiles: otro, ¿cual? --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_tc_otro">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_responsabilidadController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Terceros civiles</h4>
            </div>
            <input type="hidden" name="codigo_tc" value="00" id="tercero_otro">
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    {!! Form::label('tc_otro_cual', '¿Cuál?:') !!}
                    {!! Form::text('tc_otro_cual', null, ['class' => 'form-control','maxlength'=>190,'required'=>'required']) !!}
                </div>
                <div class="form-group col-xs-12">
                    {!! Form::label('tc_detalle', 'Detalle:') !!}
                    {!! Form::text('tc_detalle', null, ['class' => 'form-control','maxlength'=>190]) !!}
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" >Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>

        </div><!-- /.modal-content -->
        {!! Form::close() !!}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{-- Terceros civiles: otro tercero civil--}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_tc_otro_otro">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_responsabilidadController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Terceros civiles</h4>
            </div>
            <input type="hidden" name="codigo_tc" value="0401">
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    {!! Form::label('otro_actor_cual', '¿Cuál?:') !!}
                    {!! Form::text('otro_actor_cual', null, ['class' => 'form-control','maxlength'=>190,'required'=>'required']) !!}
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" >Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>

        </div><!-- /.modal-content -->
        {!! Form::close() !!}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



{{-- Terceros civiles --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_tc">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_responsabilidadController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Terceros civiles</h4>
            </div>
            <input type="hidden" name="codigo_tc" value="00" id="tercero">
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    {!! Form::label('tc_detalle', 'Detalle:') !!}
                    {!! Form::text('tc_detalle', null, ['class' => 'form-control','maxlength'=>190]) !!}
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" >Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
            <div class="clearfix"></div>
        </div><!-- /.modal-content -->
        {!! Form::close() !!}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




@push("js")
    <script>
        {{-- Llenar un arreglo que me devuelva el código de c/tipo de violencia (nivel 2) --}}
        var id_hecho = {{ $hecho->id_hecho  }};
        var tipos_aa = [];
        var tipos_tc = [];
        @foreach(\App\Models\tipo_aa::where('nivel',2)->orderby('codigo')->get() as $item)
            tipos_aa[{{ $item->id_geo }}] = '{{ $item->codigo }}';
        @endforeach
        @foreach(\App\Models\tipo_tc::where('nivel',2)->orderby('codigo')->get() as $item)
            tipos_tc[{{ $item->id_geo }}] = '{{ $item->codigo }}';
        @endforeach



        //Determina si hay que mostrar un formulario o si simplemente se agrega
        function agregar_aa() {
            let cual=$('#id_tipo_aa').val();
            let codigo = tipos_aa[cual];
            if(codigo=='0101') {
                //Paramilitar
                $('#modal_aa_0101').modal('show')
            }
            if(codigo=='0203') {
                //Otro grupo guerrila
                $('#modal_aa_0203').modal('show')
            }
            else if (codigo=='0299') {
                //guerrilla, detalle desconocido
                $('#modal_aa_0299').modal('show')
            }
            else if (codigo.substring(0,2)=='02') {
                //guerrilla
                $('#guerrilla').val(codigo);
                $('#modal_aa_02').modal('show')
            }
            else if (codigo.substring(0,2)=='03') {
                //fuerza publica
                $('#fuerza_publica').val(codigo);
                $('#modal_aa_03').modal('show')
            }
            else if (codigo=='0401') {
                //otro actor armado
                $('#modal_aa_0401').modal('show')
            }
            else if (codigo=='0402') {
                //otro actor armado
                $('#modal_aa_0402').modal('show')
            }
            else if (codigo=='0501') {
                //otro actor armado
                $('#modal_aa_0501').modal('show')
            }
            else if (codigo=='0199') {
                //paramiltar, detalle desconocido
                $('#modal_aa_0199').modal('show')
            }

        }

        //Determina si hay que mostrar un formulario o si simplemente se agrega
        function agregar_tc() {
            let cual=$('#id_tipo_tc').val();
            let codigo = tipos_tc[cual];

            if(codigo=='0107' || codigo=='0205' || codigo=='0303' ) {
                // Versiones con Otro, cual?
                $('#tercero_otro').val(codigo);
                $('#modal_tc_otro').modal('show')
            }
            else if(codigo=='0401') {
                //Otro tercero civil
                $('#modal_tc_otro_otro').modal('show')
            }
            else {
                //Cualquier tercerocivil
                $('#tercero').val(codigo);
                $('#modal_tc').modal('show')
            }
        }

    </script>


@endpush