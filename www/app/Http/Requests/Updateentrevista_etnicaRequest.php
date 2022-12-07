<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\entrevista_etnica;

class Updateentrevista_etnicaRequest extends FormRequest
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
        // return entrevista_etnica::$rules;
        if (entrevista_etnica::si_valida_campos())
            return entrevista_etnica::$rules;
        return [];        
    }
}
