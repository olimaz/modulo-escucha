<div class="row">
    @if($conteos->alerta_conteo>0)
        {{-- Datos de la entrevista --}}
        <div class="col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-flag-o"></i></span>

                <div class="info-box-content">
                    <ol class="text-danger">
                        @foreach($conteos->alerta_txt as $alerta)
                            <li> {!! $alerta !!} </li>
                        @endforeach
                    </ol>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
    @endif

    {{-- hechos --}}
    <div class="col-sm-3">
        <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-comment-o"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Fichas de hechos</span>
                <span class="info-box-number">{{ $conteos->hechos }}</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                 {{ $conteos->violencia }} violencias registradas
            </span>
            </div>
        </div>
    </div>
    {{-- violaciones --}}
    <div class="col-sm-3">
        <div class="info-box bg-aqua ">
            <span class="info-box-icon "><i class="fa fa-bolt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Cantidad de violaciones</span>
                <span class="info-box-number">{{ $conteos->violaciones }}</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                Cantidad de víctimas que sufren violencias
            </span>
            </div>
        </div>
    </div>



</div>
<div class="clearfix"></div>

{{-- antiguas alertas --}}
@if(false)
    {{-- STATS --}}
    <div class="row">
        {{-- victima --}}
        <div class="col-sm-3">
            <div class="info-box  {{ $conteos->color_victima }}">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Fichas de víctima</span>
                    <span class="info-box-number">{{ $conteos->victimas }}</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                        {{ $conteos->victimas_pendientes }} sin ficha de hechos
                    </span>
                </div>
            </div>
        </div>
        {{-- hechos --}}
        <div class="col-sm-3">
            <div class="info-box {{ $conteos->color_hechos }}">
                <span class="info-box-icon"><i class="fa fa-sitemap"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Fichas de hechos</span>
                    <span class="info-box-number">{{ $conteos->hechos }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                         {{ $conteos->violencia }} violencias registradas
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="info-box {{ $conteos->color_violaciones }} ">
                <span class="info-box-icon "><i class="fa fa-bolt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Cantidad de violaciones</span>
                    <span class="info-box-number">{{ $conteos->violaciones }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                        Cantidad de víctimas que sufren violencias
                    </span>
                </div>
            </div>
        </div>
        {{--
        <div class="col-sm-3">
            <div class="info-box {{ $conteos->color_responsables }}">
                <span class="info-box-icon "><i class="fa fa-user-secret"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Fichas de Presunto Responsable</span>
                    <span class="info-box-number">{{ $conteos->responsables }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                        {{ $conteos->responsables_pendientes }} sin ficha de hechos
                </span>
                </div>

            </div>
        </div>
        --}}
        <div class="col-sm-3">
            <div class="info-box {{ $conteos->color_adjunto }}">

                <span class="info-box-icon "> <a href="{{ action('entrevista_individualController@gestionar_adjuntos',$expediente->id_e_ind_fvt) }}"><i class="fa fa-paperclip text-gray"></i></a></span>

                <div class="info-box-content">
                    <span class="info-box-text">Archivos adjuntos</span>
                    <span class="info-box-number">{{ $conteos->adjuntos }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                        <a class="text-gray" href="{{ action('entrevista_individualController@gestionar_adjuntos',$expediente->id_e_ind_fvt) }}">Gestión de adjuntos</a>
                </span>
                </div>

            </div>
        </div>
    </div>
@endif