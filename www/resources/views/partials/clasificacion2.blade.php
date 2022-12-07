{{-- igual que el de clasificacion, pero con otro nombre en los campos (clasifica a clasificacion) --}}
@php
    $nna = isset($nna) ? $nna : 1;
    $res = isset($res) ? $res : 1;
    $sex = isset($sex) ? $sex : 1;
@endphp


<div class="clearfix"></div>
<div class="col-sm-12">
    <div class="box box-success box-solid">
        <div class="box-header">
            <h3 class="box-title ">
                Clasificar  acceso a la información
            </h3>
        </div>
        <div class="box-body">
            <div class="col-sm-12">
                <p>
                    1. Este expediente, ¿incluye declaraciones de algún <span class="text-green">niño, niña o adolescente</span>?
                </p>

                <label class="radio-inline icheck">
                    <input type="radio" name="clasificacion_nna" id="clasificacion_nna_1" value="1" {{ $nna==1 ? " checked " : "" }}> Sí
                </label>
                <label class="radio-inline icheck">
                    <input type="radio" name="clasificacion_nna" id="clasificacion_nna_2" value="2" {{ $nna==2 ? " checked " : "" }} > No
                </label>
                <hr>
            </div>


            <div class="col-sm-12">
                <p>
                    2. Este expediente, ¿incluye información de <span class="text-green">violencia sexual</span>?
                </p>

                <label class="radio-inline icheck">
                    <input type="radio" name="clasificacion_sex" id="clasificacion_sex_1" value="1" {{ $sex==1 ? " checked " : "" }}> Sí
                </label>
                <label class="radio-inline icheck">
                    <input type="radio" name="clasificacion_sex" id="clasificacion_sex_2" value="2" {{ $sex==2 ? " checked " : "" }} > No
                </label>
                <hr>
            </div>

            <div class="col-sm-12">
                <p>
                    3. Este expediente, ¿incluye <span class="text-green">reconocimiento de responsabilidades individuales</span>?
                </p>

                <label class="radio-inline icheck">
                    <input type="radio" name="clasificacion_res" id="clasificacion_res_1" value="1" {{ $res==1 ? " checked " : "" }}> Sí
                </label>
                <label class="radio-inline icheck">
                    <input type="radio" name="clasificacion_res" id="clasificacion_res_2" value="2" {{ $res==2 ? " checked " : "" }}> No
                </label>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function(){
            $('.icheck').iCheck({
                checkboxClass: 'icheckbox_square',
                radioClass: 'iradio_square-green',
                increaseArea: '20%' // optional
            });
        });
    </script>

@endpush
