<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidarRequest extends FormRequest
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
        return ['id'=>'required',
                'stock'=>'required',
            //
        ];
    }

public function messages()
{
    return [
        'id.required' => 'A title is required',
        'stock.required'  => 'Error, Recuerda que los formatos de ingreso son.'."\n".
                              'Para articulos que se vendende por gramo :'."\n".
                               '(23.75) , (1,2,3) , (0.5)         .'."\n".
                


                 ' "recuerda que  puede ir una  o dos cifras despues del  punto decimal"  '."\n".
                        '  Para articulos que se vendende por pieza :'."\n".
                           ' Numeros del 1,2,3,,4,5,6,7,8 ect.',
    ];
}










}
