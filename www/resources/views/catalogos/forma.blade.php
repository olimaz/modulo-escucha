<div class="row container">
    <div class="col-md-6 col-md-offset-3">
        <h3 class="page-header">Familias de materiales</h3>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    {!! Form::label('descrip_item',"Nombre") !!}
                    {!! Form::text('descrip_item', null, ["class"=>"form-control"]) !!}
                </div>


                <div class="form-group">
                    {!! Form::submit($submitButtonText,["class"=>"btn btn-primary"])!!}
                    <a href="{{ action("familiasController@index") }}" class="btn btn-default pull-right">Cancelar</a>
                </div>

            </div>
        </div>
    </div>
</div>


