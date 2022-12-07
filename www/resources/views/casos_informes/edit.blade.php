@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Casos Informes
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($casosInformes, ['route' => ['casosInformes.update', $casosInformes->id_casos_informes], 'method' => 'patch']) !!}

                        @include('casos_informes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection

@push("js")
    <script>
        $(function() {

            @if($casosInformes->clasifica_nna==1)
            $("#clasifica_nna_1").iCheck('check');
            @else
            $("#clasifica_nna_2").iCheck('check');
            @endif
            //
            @if($casosInformes->clasifica_sex==1)
            $("#clasifica_sex_1").iCheck('check');
            @else
            $("#clasifica_sex_2").iCheck('check');
            @endif
            //
            @if($casosInformes->clasifica_res==1)
            $("#clasifica_res_1").iCheck('check');
            @else
            $("#clasifica_res_2").iCheck('check');
            @endif
        });
    </script>
@endpush