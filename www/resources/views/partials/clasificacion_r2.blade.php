{{-- este incluye elevar a R-2--}}
@php
    $nna = isset($nna) ? $nna : 1;
    $res = isset($res) ? $res : 1;
    $sex = isset($sex) ? $sex : 1;
    $r2 = isset($r2) ? $r2 : 2;
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
                    <input type="radio" name="clasifica_nna" id="clasifica_nna_1" value="1" {{ $nna == 1 ? " checked " : "" }}> Sí
                </label>
                <label class="radio-inline icheck">
                    <input type="radio" name="clasifica_nna" id="clasifica_nna_2" value="2" {{ $nna == 2 ? " checked " : "" }}> No
                </label>
                <hr>
            </div>


            <div class="col-sm-12">
                <p>
                    2. Este expediente, ¿incluye información de <span class="text-green">violencia sexual</span>?
                </p>

                <label class="radio-inline icheck">
                    <input type="radio" name="clasifica_sex" id="clasifica_sex_1" value="1" {{ $sex == 1 ? " checked " : "" }}> Sí
                </label>
                <label class="radio-inline icheck">
                    <input type="radio" name="clasifica_sex" id="clasifica_sex_2" value="2" {{ $sex <> 1 ? " checked " : "" }}> No
                </label>
                <hr>
            </div>

            <div class="col-sm-12">
                <p>
                    3. Este expediente, ¿incluye <span class="text-green">reconocimiento de responsabilidades individuales</span>?
                </p>

                <label class="radio-inline icheck">
                    <input type="radio" name="clasifica_res" id="clasifica_res_1" value="1" {{ $res == 1 ? " checked " : "" }}> Sí
                </label>
                <label class="radio-inline icheck">
                    <input type="radio" name="clasifica_res" id="clasifica_res_2" value="2" {{ $res <> 1 ? " checked " : "" }}> No
                </label>
                <hr>
            </div>
            <div class="col-sm-12">
                <p>
                    4. Dadas las características de este expediente, ¿desea <span class="text-green">clasificarlo como R-2</span>?
                </p>

                <label class="radio-inline icheck">
                    <input type="radio" name="clasifica_r2" id="clasificacion_r2_1" value="1" {{ $r2 ==1 ? " checked " : "" }}> Sí
                </label>
                <label class="radio-inline icheck">
                    <input type="radio" name="clasifica_r2" id="clasificacion_r2_2" value="2" {{ $r2 ==2 ? " checked " : "" }}> No
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
