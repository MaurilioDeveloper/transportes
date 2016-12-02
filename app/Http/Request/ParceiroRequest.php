<?php

namespace App\Http\Request;

use App\Parceiro;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Created by PhpStorm.
 * User: Maurilio
 * Date: 23/11/2016
 * Time: 13:45
 */
class ParceiroRequest extends FormRequest
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
        $pessoa = Parceiro::getPessoa($this->get('pessoa'));
        $documentType = $pessoa == Parceiro::PESSOA_FISICA ? 'cpf' : 'cnpj';
        $id = $this->route('parceiro');
        $rules = [
            'nome' => 'required|max:100',
            'documento' => "required|documento:$documentType|unique:parceiros,documento,$id",
            'email' => 'required|email',
            'telefone' => 'required',
        ];

        if ($pessoa == Parceiro::PESSOA_FISICA) {
            $estadosCivis = implode(',', array_keys(Parceiro::ESTADOS_CIVIS));
            $rules = array_merge($rules, [
                'data_nasc' => 'required|date',
                'estado_civil' => "required|in:$estadosCivis",
                'sexo' => 'required|in:m,f'
            ]);
        } else {
            $rules = array_merge($rules, [
                'fantasia' => 'required',
            ]);
        }

        return $rules;

    }

}