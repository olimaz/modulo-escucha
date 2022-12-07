{{-- USADO en el show --}}
@if(count($consentimiento->consentimiento_alertas)>0)
    <div class="box box-solid box-danger">
        <div class="box-header">
            <h3 class="box-title">
                <i class="fa fa-hand-o-right"></i> Advertencia sobre el consentimiento informado
            </h3>
        </div>
        <div class="box-body">
            <ul>
                @foreach($consentimiento->consentimiento_alertas as $alerta)
                    <li>{{ $alerta }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif