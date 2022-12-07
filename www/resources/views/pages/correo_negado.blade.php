@extends('layouts.mensajes')



@section('content')
    No se admiten correos personales<br><br>
    Debe autenticarse con su correo institucional: <b>@comisiondelaverdad.co</b>
    <br>Puede intentar de nuevo utilizando <a href=" {{ url('redirect') }}">este enlace</a></br>
@stop