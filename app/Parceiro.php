<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Notifications\Notifiable;

class Parceiro extends Model
{

    const ESTADOS_CIVIS = [
        1 => 'Solteiro',
        2 => 'Casado',
        3 => 'Divorciado'
    ];

    const ESTADOS = 'PR';

    const PESSOA_FISICA = 'fisica';
    const PESSOA_JURIDICA = 'juridica';

    protected $fillableGeneral = [
        'nome',
        'documento',
        'email',
        'telefone',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cep',
        'cidade',
        'estado',
        'site'
    ];

    protected $fillableFisica = [
        'data_nasc',
        'sexo',
        'estado_civil',
        'deficiencia_fisica'
    ];

    protected $fillableJuridica = [
        'fantasia',
        'inscricao_estadual'
    ];


    static $rules = [
        'nome' => 'required',
        'documento' => 'unique:parceiros'
    ];

    public static function getPessoa($value)
    {
        return $value == Parceiro::PESSOA_JURIDICA ? $value : Parceiro::PESSOA_FISICA;
    }

    protected function setFillable()
    {
        if ($this->pessoa == self::PESSOA_FISICA) {
            $this->fillable(array_merge($this->fillableGeneral, $this->fillableFisica));
        } else {
            $this->fillable(array_merge($this->fillableGeneral, $this->fillableJuridica));
        }
    }

    public function fill(array $attributes)
    {
        if (!$this->pessoa) {
            $this->pessoa = self::getPessoa(isset($attributes['pessoa']) ? $attributes['pessoa'] : null);
        }
        $this->setFillable();
        return parent::fill($attributes);
    }

    public function getSexoFormattedAttribute()
    {
        return $this->sexo == 'm' ? 'Masculino' : 'Feminino';
    }

    public function setDocumentoAttribute($value)
    {
        $this->attributes['documento'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function getDocumentoFormattedAttribute()
    {
        $string = $this->documento;

        if(strlen($string) == 0){
            $string = NULL;
        }else {
            if (!empty($string)) {
                if (strlen($string) == 11) {
                    $string = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $string);
                } else {
                    $string = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3.$4-$5', $string);
                }
            }
        }

        return $string;
    }

    public function getDataNascFormattedAttribute()
    {
        return $this->pessoa == self::PESSOA_FISICA ? (new \DateTime($this->data_nasc))->format('d/m/Y') : "";
    }

}
