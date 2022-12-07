{{-- nueva entrada --}}
@can('sistema-abierto')
@if(in_array($misCasos->privilegios,[1,5]))
<div class="col-xs-12">
    <div class="box box-primary  {{ count($misCasos->blog) >0 ? ' collapsed-box ' : '' }}">
        <div class="box-header">
            <h1 class="box-title">Agregar nueva nota</h1>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            {!! Form::open(['route' => 'blogs.store']) !!}
                <input type="hidden" name="id_mis_casos" id="id_mis_casos" value="{{ $misCasos->id_mis_casos }}">
                @include('blogs.fields')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endif
@endcan
<div  class="clearfix"></div>

@php($listado = $misCasos->blog)
@include("blogs.timeline")

<div  class="clearfix"></div>

