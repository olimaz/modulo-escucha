
    <div class="row">
        <div class="col-sm-2">
            <br>
            <p class="text-muted">
                Escoja el tipo de violencia mencionada en el relato:
            </p>
        </div>
        <div class="col-sm-7">

                @include('controles.tipo_violencia', ['control_control' => 'id_tipo_violencia'
                            ,'control_texto' => ''
                            ])

        </div>
        <div class="col-sm-2 text-center">
            <br><br>
            <button type="button" class="btn btn-default" onclick="agregar_violencia()">Agregar al presente hecho</button>
        </div>
    </div>


{{-- Masacre --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_0502">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_violenciaController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Masacre</h4>
            </div>
            <input type="hidden" name="codigo_violencia" value="0502">
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                    <div class="form-group col-xs-12">
                        <span title="La cantidad de muertos no puede ser superior {{ $hecho->cantidad_victimas }} que es la cantidad total de víctimas especificadas para este hecho" data-toggle="tooltip">
                        {!! Form::label('cantidad_muertos', "Indique el número de muertos, (máximo $hecho->cantidad_victimas ):") !!}
                        </span>
                        {!! Form::number('cantidad_muertos', 2, ['class' => 'form-control','required'=>'required', 'min'=>2 ,'max'=>$hecho->cantidad_victimas]) !!}
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" >Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
        {!! Form::close() !!}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{-- Amenaza a la vida --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_0701">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_violenciaController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Amenaza al derecho a la vida</h4>
            </div>
            <input type="hidden" name="codigo_violencia" value="0701">
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_individual_colectiva'
                                                              ,'control_id_cat'=>172
                                                              , 'control_multiple' => false
                                                              , 'control_requerido' => true
                                                              ,'control_texto'=>'Tipo de amenaza:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_mecanismo'
                                                              ,'control_id_cat'=>122
                                                              , 'control_multiple' => true
                                                              , 'control_requerido' => true
                                                              ,'control_texto'=>'Tipo de amenaza:'])
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

{{-- Desaparición forzada --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_0801">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_violenciaController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Desaparición forzada</h4>
            </div>
            <input type="hidden" name="codigo_violencia" value="0801">
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">

                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_mecanismo'
                                                              ,'control_id'=>'id_mecanismo_0801'
                                                              ,'control_id_cat'=>124
                                                              , 'control_multiple' => true
                                                              , 'control_requerido' => true
                                                              ,'control_texto'=>'Especificar:'])
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

{{-- Tortura física --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_0901">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_violenciaController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tortura y otros hechos crueles, inhumanos o degradantes</h4>
            </div>
            <input type="hidden" name="codigo_violencia" value="0901">
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_individual_colectiva'
                                                              ,'control_id'=>'id_individual_colectiva_0901'
                                                              ,'control_id_cat'=>172
                                                              , 'control_multiple' => false
                                                              , 'control_requerido' => true
                                                              ,'control_texto'=>'Tipo de tortura:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.radio_si_no', ['control_control' => 'id_frente_otros'
                                                              , 'control_predeterminado' => 2
                                                              ,'control_id'=>'id_frente_otros_0901'
                                                              ,'control_texto'=>'¿Los hechos fueron cometidos frente a otras personas?:'])
                </div>

                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_mecanismo'
                                                              ,'control_id'=>'id_mecanismo_0901'
                                                              ,'control_id_cat'=>120
                                                              , 'control_multiple' => true
                                                              , 'control_requerido' => true
                                                              ,'control_texto'=>'Especificar:'])
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

{{-- Tortura psicológica --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_0902">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_violenciaController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tortura y otros hechos crueles, inhumanos o degradantes</h4>
            </div>
            <input type="hidden" name="codigo_violencia" value="0902">
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_individual_colectiva'
                                                              ,'control_id'=>'id_individual_colectiva_0902'
                                                              ,'control_id_cat'=>172
                                                              , 'control_multiple' => false
                                                              , 'control_requerido' => true
                                                              ,'control_texto'=>'Tipo de tortura:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.radio_si_no', ['control_control' => 'id_frente_otros'
                                                              , 'control_predeterminado' => 2
                                                              ,'control_id'=>'id_frente_otros_0902'
                                                              ,'control_texto'=>'¿Los hechos fueron cometidos frente a otras personas?:'])
                </div>

                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_mecanismo'
                                                              ,'control_id'=>'id_mecanismo_0902'
                                                              ,'control_id_cat'=>121
                                                              , 'control_multiple' => true
                                                              , 'control_requerido' => true
                                                              ,'control_texto'=>'Especificar:'])
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

{{-- Violencia sexual --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_10">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_violenciaController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Violencia sexual</h4>
            </div>
            <input type="hidden" name="codigo_violencia" value="10" id="violencia_sexual">
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_individual_colectiva'
                                                              ,'control_id'=>'id_individual_colectiva_10'
                                                              ,'control_id_cat'=>172
                                                              , 'control_multiple' => false
                                                              , 'control_requerido' => true
                                                              ,'control_texto'=>'Tipo de violencia sexual:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.radio_si_no', ['control_control' => 'id_frente_otros'
                                                              , 'control_predeterminado' => 2
                                                              ,'control_id'=>'id_frente_otros_10'
                                                              ,'control_texto'=>'¿Los hechos fueron cometidos frente a otras personas?:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.radio_si_no', ['control_control' => 'id_cometido_varios'
                                                              , 'control_predeterminado' => 2
                                                              ,'control_id'=>'id_cometido_varios_10'
                                                              ,'control_texto'=>'¿Los hechos fueron cometidos por varias personas?:'])
                </div>

                <div class="form-group col-xs-12">
                    @include('controles.radio_si_no', ['control_control' => 'id_hubo_embarazo'
                                                              , 'control_predeterminado' => 2
                                                              ,'control_id'=>'id_hubo_embarazo_10'
                                                              ,'control_texto'=>'¿Hubo embarazo como consecuencia de la violación sexual?:'])
                </div>

                <div class="form-group col-xs-12">
                    @include('controles.radio_si_no', ['control_control' => 'id_hubo_nacimiento'
                                                              , 'control_predeterminado' => 2
                                                              ,'control_id'=>'id_hubo_nacimiento_10'
                                                              ,'control_texto'=>'Si hubo embarazo, ¿nació el bebé?:'])
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

{{--Esclavitud / trabajo forzoaso --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_1101">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_violenciaController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Esclavitud / Trabajo forzoso sin fines sexuales</h4>
            </div>
            <input type="hidden" name="codigo_violencia" value="1101" >
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_individual_colectiva'
                                                              ,'control_id'=>'id_individual_colectiva_1101'
                                                              ,'control_id_cat'=>172
                                                              , 'control_multiple' => false
                                                              , 'control_requerido' => true
                                                              ,'control_texto'=>'Tipo de violencia:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.radio_si_no', ['control_control' => 'id_frente_otros'
                                                              , 'control_predeterminado' => 2
                                                              ,'control_id'=>'id_frente_otros_1101'
                                                              ,'control_texto'=>'¿Los hechos fueron cometidos frente a otras personas?:'])
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

{{-- Reclutamiento NNA --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_1201">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_violenciaController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Reclutamiento de niños, niñas y adolescentes</h4>
            </div>
            <input type="hidden" name="codigo_violencia" value="1201" >
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_individual_colectiva'
                                                              ,'control_id'=>'id_individual_colectiva_1201'
                                                              ,'control_id_cat'=>172
                                                              , 'control_multiple' => false
                                                              , 'control_requerido' => true
                                                              ,'control_texto'=>'Tipo de violencia:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.radio_si_no', ['control_control' => 'id_frente_otros'
                                                              , 'control_predeterminado' => 2
                                                              ,'control_id'=>'id_frente_otros_1201'
                                                              ,'control_texto'=>'¿Los hechos fueron cometidos frente a otras personas?:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_mecanismo'
                                                              ,'control_id'=>'id_mecanismo_1201'
                                                              ,'control_id_cat'=>123
                                                              , 'control_multiple' => true
                                                              , 'control_requerido' => true
                                                              ,'control_texto'=>'Especificar:'])
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


{{-- Detención arbitraria --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_1301">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_violenciaController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detención arbitraria</h4>
            </div>
            <input type="hidden" name="codigo_violencia" value="1301" >
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_ind_fam_col'
                                                              ,'control_id'=>'id_ind_fam_col_1301'
                                                              ,'control_id_cat'=>149
                                                              , 'control_multiple' => false
                                                              , 'control_requerido' => true
                                                              ,'control_texto'=>'Tipo de violencia:'])
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

{{-- Secuestro / toma de rehenes --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_1401">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_violenciaController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Secuestro / toma de rehenes</h4>
            </div>
            <input type="hidden" name="codigo_violencia" value="1401" >
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_ind_fam_col'
                                                              ,'control_id'=>'id_ind_fam_col_1301'
                                                              ,'control_id_cat'=>149
                                                              , 'control_multiple' => false
                                                              , 'control_requerido' => true
                                                              ,'control_texto'=>'Tipo de violencia:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.radio_si_no', ['control_control' => 'id_frente_otros'
                                                              , 'control_predeterminado' => 2
                                                              ,'control_id'=>'id_frente_otros_1301'
                                                              ,'control_texto'=>'¿Los hechos fueron cometidos frente a otras personas?:'])
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

{{-- Confinamiento --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_1501">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_violenciaController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confinamiento</h4>
            </div>
            <input type="hidden" name="codigo_violencia" value="1501" >
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_ind_fam_col'
                                                              ,'control_id'=>'id_ind_fam_col_1501'
                                                              ,'control_id_cat'=>149
                                                              , 'control_multiple' => false
                                                              , 'control_requerido' => true
                                                              ,'control_texto'=>'Tipo de violencia:'])
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

{{-- Despojo --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_2001">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_violenciaController@agregar']]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Despojo / Abandono de tierras</h4>
            </div>
            <input type="hidden" name="codigo_violencia" value="2001" >
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_ind_fam_col'
                                                              ,'control_id'=>'id_ind_fam_col_2001'
                                                              ,'control_id_cat'=>149
                                                              , 'control_multiple' => false
                                                              , 'control_requerido' => true
                                                              ,'control_texto'=>'Tipo de violencia:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_mecanismo'
                                                              ,'control_id'=>'id_mecanismo_2001'
                                                              ,'control_id_cat'=>125
                                                              , 'control_multiple' => true
                                                              , 'control_requerido' => true
                                                              ,'control_texto'=>'Modalidad del despojo:'])
                </div>
                <div class="form-group col-xs-12">
                    {!! Form::label('despojo_hectareas', 'Hectáreas despojadas:') !!}
                    {!! Form::number('despojo_hectareas', 0, ['class' => 'form-control','required'=>'required']) !!}
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.radio_si_no', ['control_control' => 'despojo_recupero_tierras'
                                                              , 'control_default' => 2
                                                              , 'control_opciones' => \App\Models\criterio_fijo::listado_items(10)
                                                              ,'control_texto'=>'¿Recuperó sus tierras?:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.radio_si_no', ['control_control' => 'despojo_recupero_derechos'
                                                              , 'control_predeterminado' => 2
                                                              ,'control_texto'=>'¿Recuperó sus derechos territoriales?:'])
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

{{-- Desplazamiento --}}
<div class="modal fade" tabindex="-1" role="dialog" id="modal_2101">
    <div class="modal-dialog " role="document">
        {!! Form::open(['action' => ['hecho_violenciaController@agregar'], 'id'=>'frm_desplazamiento']) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Desplazamiento forzado</h4>
            </div>
            <input type="hidden" name="codigo_violencia" value="2101" >
            <input type="hidden" name="id_hecho" value="{{ $hecho->id_hecho }}">
            <div class="modal-body">
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_ind_fam_col'
                                                              ,'control_id'=>'id_ind_fam_col_2101'
                                                              ,'control_id_cat'=>149
                                                              , 'control_multiple' => false
                                                              , 'control_requerido' => true
                                                              ,'control_texto'=>'Tipo de desplazamiento:'])
                </div>

                <div class="form-group col-xs-12">
                    @include('controles.geo3', ['control_control' => 'id_lugar_salida'
                                ,'control_texto' => 'Lugar de orígen:'
                                ,'control_select_2' => false
                                ,'control_vacio' => '[Sin especificar]'
                                , 'control_default'=>$hecho->id_lugar])
                </div>

                <div class="form-group col-xs-12">
                    @include('controles.geo3', ['control_control' => 'id_lugar_llegada'
                                ,'control_texto' => 'Lugar de llegada:'
                                ,'control_select_2' => true
                                 ,'control_vacio' => '[Sin especificar]'
                                , 'control_default'=>$hecho->id_lugar])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_sentido_desplazamiento'
                                                              ,'control_id_cat'=>126
                                                              , 'control_multiple' => false
                                                              , 'control_requerido' => true
                                                              ,'control_texto'=>'Sentido del desplazamiento:'])
                </div>


                <div class="form-group col-xs-12">
                    @include('controles.radio_si_no', ['control_control' => 'id_tuvo_retorno'
                                                              , 'control_predeterminado' => 2
                                                              ,'control_texto'=>'¿La persona ha tenido un proceso de retorno?:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_tuvo_retorno_tipo'
                                                              ,'control_id_cat'=>149
                                                              , 'control_multiple' => false
                                                              , 'control_requerido' => false
                                                              , 'control_vacio' => "[No tuvo proceso de retorno]"
                                                              ,'control_texto'=>'Si tuvo proceso de retorno,  especifique el tipo:'])
                </div>




                <div class="clearfix"></div>
                <span class="text-primary pull-left"><i class="fa fa-hand-o-right"></i> Si tuvo otros desplazamientos, especificarlos en otros hechos por separados.</span>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">

                <button type="submit" class="btn btn-primary" id="btn_desplazamiento" >Añadir</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
        {!! Form::close() !!}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

    @push("js")
        <script>
            $("#frm_desplazamiento").submit(function( event ) {
                if ( $("#id_lugar_salida_depto").val() <= 0 ) {
                    event.preventDefault();
                    Swal.fire({
                        type: 'error',
                        title: 'Lugar de salida',
                        text: 'Por favor, indique como mínimo el departamento del lugar de salida.'
                    })
                }

                if ( $("#id_lugar_llegada_depto").val() <= 0 ) {
                    event.preventDefault();
                    Swal.fire({
                        type: 'error',
                        title: 'Lugar de llegada',
                        text: 'Por favor, indique como mínimo el departamento del lugar de llegada.'
                    })

                }
                return;
            });
        </script>
    @endpush






@push("js")

    <script>
        {{-- Llenar un arreglo que me devuelva el código de c/tipo de violencia (nivel 2) --}}
        var id_hecho = {{ $hecho->id_hecho  }};
        var tipos_violencia = [];
        @foreach(\App\Models\tipo_violencia::where('nivel',2)->orderby('codigo')->get() as $item)
            tipos_violencia[{{ $item->id_geo }}] = '{{ $item->codigo }}';
        @endforeach

        //Para los tipos que no tienen personalizacion
        function agregar_simple(cual) {
            var form_data = new FormData();
            form_data.append('id_hecho', id_hecho);
            form_data.append('id_subtipo_violencia',cual);
            form_data.append('_token', '{{csrf_token()}}');
            form_data.append('ajax',true);
            //console.log("agregar_simple");
            //console.log(form_data);
            $.ajax({
                url: "{{url('hecho/violencia/agregar')}}",
                data: form_data,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (data) {
                    //console.log(data);
                    document.location.reload();
                },
                error: function (xhr, status, error) {
                    //alert(xhr.responseText);
                    Swal.fire(
                        'Violencia no agregada:',
                        xhr.responseText,
                        'error'
                       )

                }
            });
        }
        //Para los tipos que tienen personalización
        function agregar_de_formulario(formulario) {
            var div="#"+formulario+" :input";
            var controles = $(div);
            //console.log("Agregar de formulario");
            //console.log(controles);
        }

        //Determina si hay que mostrar un formulario o si simplemente se agrega
        function agregar_violencia() {
            let cual=$('#id_tipo_violencia').val();
            let codigo = tipos_violencia[cual];
            if(codigo=='0502') {
                //alert('pedir cantidad de muertos')
                $('#modal_0502').modal('show')
            }
            else if (codigo=='0701') {
                $('#modal_0701').modal('show')
            }
            else if (codigo=='0801') {
                $('#modal_0801').modal('show')
            }
            else if (codigo=='0901') {
                $('#modal_0901').modal('show')
            }
            else if (codigo=='0902') {
                $('#modal_0902').modal('show')
            }
            else if (codigo.substring(0,2)=='10') {
                $('#violencia_sexual').val(codigo);
                $('#modal_10').modal('show')
            }
            else if (codigo=='1101') {
                $('#modal_1101').modal('show')
            }
            else if (codigo=='1201') {
                $('#modal_1201').modal('show')
            }
            else if (codigo=='1301') {
                $('#modal_1301').modal('show')
            }
            else if (codigo=='1401') {
                $('#modal_1401').modal('show')
            }
            else if (codigo=='1501') {
                $('#modal_1501').modal('show')
            }
            else if (codigo=='2001') {
                $('#modal_2001').modal('show')
            }
            else if (codigo=='2101') {
                $('#modal_2101').modal('show')
            }
            else {
               // alert ('agregar directamente');
                agregar_simple(cual);
            }
            //document.location.reload();
        }

    </script>


@endpush