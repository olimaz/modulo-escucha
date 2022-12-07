

<!-- Titulo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('titulo', 'Título:') !!}
    {!! Form::text('titulo', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Html Field -->
<div class="form-group col-sm-12 col-lg-12">

    {!! Form::textarea('html', null, ['class' => 'form-control','required'=>'required','id'=>'html']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">

    {!! Form::submit('Grabar', ['class' => 'btn btn-primary']) !!}

</div>

@push("js")
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                lang: 'ko-KR' // default: 'en-US'
            });
        });

        $(function () {
            $('#html').summernote({
                lang: 'es-ES',
                height: 200,
                tabsize: 2,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold','italic' ,'underline', 'clear']],
                    //['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    //['table', ['table']],
                    //['insert', ['link', 'picture', 'video']],
                    //['view', ['fullscreen', 'codeview', 'help']]
                ]
            });


        })
    </script>

@endpush