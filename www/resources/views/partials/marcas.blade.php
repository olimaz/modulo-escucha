@can('sistema-abierto')
    @if(isset($marcas))  {{-- Por si acaso --}}
        @if(strlen($marcas)>0)
            <div >
                <i class="fa fa-flag text-primary" aria-hidden="true"></i> {!!  $marcas  !!}
            </div>
        @endif
    @endif
@endcan