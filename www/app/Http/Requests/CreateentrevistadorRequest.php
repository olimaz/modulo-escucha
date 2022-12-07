<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\entrevistador;

class CreateentrevistadorRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(\Gate::check('login-local')) {
            return entrevistador::$rules_local;
        }
        else {
            return entrevistador::$rules;
        }

    }
}
