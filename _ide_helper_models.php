<?php
/**
 * An helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Parceiro
 *
 * @property integer $id
 * @property string $tipo
 * @property string $rg
 * @property string $cpf
 * @property string $inscricaoEstadual
 * @property string $cnpj
 * @property string $endereco
 * @property integer $numero
 * @property string $complemento
 * @property string $bairro
 * @property integer $cep
 * @property string $cidade
 * @property string $estado
 * @property string $site
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $sexo_formatted
 * @property-write mixed $documento
 * @property-read mixed $documento_formatted
 * @property-read mixed $data_nasc_formatted
 * @method static \Illuminate\Database\Query\Builder|\App\Parceiro whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Parceiro whereTipo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Parceiro whereRg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Parceiro whereCpf($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Parceiro whereInscricaoEstadual($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Parceiro whereCnpj($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Parceiro whereEndereco($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Parceiro whereNumero($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Parceiro whereComplemento($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Parceiro whereBairro($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Parceiro whereCep($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Parceiro whereCidade($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Parceiro whereEstado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Parceiro whereSite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Parceiro whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Parceiro whereUpdatedAt($value)
 */
	class Parceiro extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $readNotifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $unreadNotifications
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

