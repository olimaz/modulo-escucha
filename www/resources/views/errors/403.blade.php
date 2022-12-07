@extends('layouts.error')




@section('content')
   Acceso denegado
   @if(strlen($exception->getMessage())>0)
      - {{ $exception->getMessage() }}
   @endif
@endsection