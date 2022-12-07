@if(config('expedientes.login_local'))
    @include('auth.login_local')
@else
    @include('adminlte::login')
@endif