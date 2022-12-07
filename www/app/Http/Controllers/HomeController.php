<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::check()) {
            if(\Auth::user()->tiene_perfil()) {
                $avisar=\Auth::user()->toca_cambio;
                if($avisar) {
                    //dd("Avisar");
                    return redirect(url('ver_perfil'));
                }
            }

            if(\Gate::allows('solo-estadistica')) {
                return redirect(url('dash'));
            }
            if(\Gate::allows('revisar-m-nivel',[[1,2,6]])) {
                return redirect(url('buscador'));
            }
            elseif(\Gate::allows('revisar-m-nivel',[[11]])) {
                return redirect(action('transcribir_asignacionController@index'));
            }
            else {
                return redirect(url('entrevistaIndividuals')."?id_subserie=".config('expedientes.vi'));
            }
            //

        }
        else {
            //return view('welcome');
            return redirect('/login');
        }
    }

    // Tomado de https://adldap2.github.io/Adldap2/#/
    public function test_ldap(){
       $var = User::login_ldap("oliver.mazariegos","agosto.19");
       dd($var);
    }




}
