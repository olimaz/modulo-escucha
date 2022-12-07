@extends('layouts.app')




@section('content')
    <h1>Prueba</h1>
    @include('adminlte-templates::common.errors')

    {!! Form::open(array('url' => '#', 'files' => true,'id'=>'form')) !!}

    <input type="file" class="form-control" name="photos[]"  />

    <div id="preview"><img src="filed.png" /></div><br>


    <input type="submit" class="btn btn-primary" value="Upload" />

    {!! Form::close() !!}



@stop


@push('js')

    <script>
        $(document).ready(function (e) {
            $("#form").on('submit',(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ url('multiuploads') }}",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend : function()
                    {
                        //$("#preview").fadeOut();
                        $("#err").fadeOut();
                    },
                    success: function(data)
                    {
                        if(data=='invalid')
                        {
                            // invalid file format.
                            $("#err").html("Invalid File !").fadeIn();
                        }
                        else
                        {
                            // view uploaded file.
                            $("#preview").html(data).fadeIn();
                            $("#form")[0].reset();
                        }
                    },
                    error: function(e)
                    {
                        $("#err").html(e).fadeIn();
                    }
                });
            }));
        });
    </script>
@endpush
