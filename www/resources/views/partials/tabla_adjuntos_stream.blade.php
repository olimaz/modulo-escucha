
    @if(strlen($adjunto['url_stream'])>0)
        <audio controls controlsList="nodownload" >
            <source src="{!! $adjunto['url_stream'] !!}" type="audio/mpeg">
            Su navegador no permite transmitir audio.
        </audio>
        <br>{!! $adjunto['url_stream_corto'] !!}


        @can('es-propio',$expediente->id_entrevistador)
            <br>{!! $adjunto['url'] !!}
        @else
            @can('nivel-1')
                <br>{!! $adjunto['url'] !!}
            @else
                @can('nivel-10-al-11')
                    @php($donde = \App\User::red_interna())
                    @if($donde->red_interna)
                        <br>{!! $adjunto['url'] !!}
                    @endif
                @endcan
            @endcan
        @endcan
    @else
        {!! $adjunto['url'] !!}
    @endif

