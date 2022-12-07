{{-- MAQUETA que incluye menu y encabezados, con secciones MAIN y stack para CSS y JS --}}
@extends('layouts.admin3.html_base')
@php($colapsar_menu = isset($colapsar_menu) ? $colapsar_menu : true)



@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') || $colapsar_menu ? ' sidebar-collapse ' : ''))


@section('body')
<div class="wrapper">



        {{--
            @include("layouts.admin3.menu_superior")
            @include("layouts.admin3.menu_izquierdo")
        --}}
        @include("layouts.admin3.menu_superior_completo")


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @yield('content_header')

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="clearfix"></div>
                @include('flash::message')
                <div class="clearfix"></div>
                @yield('content')
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include("layouts.admin3.menu_derecho")

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline" >
            <a href="{{ action('fichasController@about') }}">
                Exploración de fichas
            </a>

        </div>
        <!-- Default to the left -->
        Sistema de Información Misional <strong>-SIM-</strong>  2021.
    </footer>

    {{--  --}}
        @if($con_sidebar)
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
                <div class="p-3">
                    @yield('sidebar')
                </div>
            </aside>
        @endif
</div>
<!-- ./wrapper -->
@endsection



