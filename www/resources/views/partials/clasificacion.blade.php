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
                    <input type="radio" name="clasifica_nna" id="clasifica_nna_1" value="1" checked> Sí
                </label>
                <label class="radio-inline icheck">
                    <input type="radio" name="clasifica_nna" id="clasifica_nna_2" value="2" > No
                </label>
                <hr>
            </div>


            <div class="col-sm-12">
                <p>
                    2. Este expediente, ¿incluye información de <span class="text-green">violencia sexual</span>?
                </p>

                <label class="radio-inline icheck">
                    <input type="radio" name="clasifica_sex" id="clasifica_sex_1" value="1" checked> Sí
                </label>
                <label class="radio-inline icheck">
                    <input type="radio" name="clasifica_sex" id="clasifica_sex_2" value="2" > No
                </label>
                <hr>
            </div>

            <div class="col-sm-12">
                <p>
                    3. Este expediente, ¿incluye <span class="text-green">reconocimiento de responsabilidades individuales</span>?
                </p>

                <label class="radio-inline icheck">
                    <input type="radio" name="clasifica_res" id="clasifica_res_1" value="1" checked> Sí
                </label>
                <label class="radio-inline icheck">
                    <input type="radio" name="clasifica_res" id="clasifica_res_2" value="2" > No
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
