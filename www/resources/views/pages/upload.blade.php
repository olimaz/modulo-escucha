@extends('layouts.app')




@section('content')
    <h1>Prueba</h1>
    @include('adminlte-templates::common.errors')

    <div class="row">
        <div class="col-sm-4">
            <div  class="box">
                <div class="box-header">
                    <h3 class="box-title">Consentimiento informado</h3>
                </div>
                <div class="box-body">
                    <div class="col-xs-12 text-center">
                        <h3>Carga de archivos</h3>

                        <span id="control_casilla">
                            {{--
                            <i class="fa fa-square-o fa-4x text-red" aria-hidden="true"></i>
                            --}}
                        </span>
                    </div>
                    <div class="col-xs-12">
                    <span id="control_url">
                        &nbsp;
                    </span>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-xs-6 text-center">
                        <a href="javascript:cargar('control')" class='btn btn-success'>
                            <i class="glyphicon glyphicon-file"></i> Subir archivo
                        </a>
                    </div>
                    <div class="col-xs-6 text-center">
                        <a class='btn btn-danger' href="javascript:quitar('control')" >
                            <i class="glyphicon glyphicon-trash"></i> Quitar archivo
                        </a>
                    </div>
                    <input type="file" id="control" name="control" class="carga_automatica" style="display: none"/>
                    <input type="hidden" id="control_filename"/>
                </div>
            </div>
        </div>
    </div>
@stop


@push('js')

    <script>

        var ico_si='<i class="fa fa-check-square-o fa-4x text-green" aria-hidden="true"></i>';
        var ico_no='<i class="fa fa-square-o fa-4x text-red" aria-hidden="true"></i>';
        var ico_cargando='<i class="fa fa-spinner fa-spin fa-2x fa-fw" ></i>';

        function cargar(control) {
            $('#'+control).click();
        }

        $('.carga_automatica').change(function () {
            if ($(this).val() != '') {
                upload(this);
            }
        });



        $('#file').change(function () {
            if ($(this).val() != '') {
                upload(this);
            }
        });
        function upload(img) {
            var control = img.name;


            $("#"+control+"_casilla").html(ico_cargando);

            var form_data = new FormData();
            form_data.append('file', img.files[0]);
            form_data.append('_token', '{{csrf_token()}}');
            form_data.append('control',img.name);
            $.ajax({
                url: "{{url('/upload')}}",
                data: form_data,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.fail) {
                        $("#"+control+"_casilla").html(ico_no);
                        $("#"+control+"_filename").val("");
                        $("#"+control+"_url").html("");
                        alert(data.errors['file']);
                        //$('#preview_image').attr('src', '{{asset('images/noimage.jpg')}}');
                    }
                    else {
                        $("#"+control+"_filename").val(data);
                        $("#"+control+"_casilla").html(ico_si);
                        $("#"+control+"_url").html("<a href='{{ url('/') }}"+ data+"' target='_blank'>Comprobar el archivo cargado</a>");
                        //$('#file_name').val(data);
                        //$('#preview_image').attr('src', '{{ url('/') }}' + data);
                    }
                    //$('#loading').css('display', 'none');
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseText);
                    //$('#preview_image').attr('src', '{{asset('images/noimage.jpg')}}');
                }
            });
        }

        function quitar(control) {
            $("#"+control+"_casilla").html(ico_no);
            $("#"+control+"_filename").val("");
            $("#"+control+"_url").html("");

        }
    </script>
@endpush
