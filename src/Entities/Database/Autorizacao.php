<?php
/**
 * Created by PhpStorm.
 * User: anderson
 * Date: 25/07/17
 * Time: 16:33
 */

namespace Girolando\Oauth2Layer\Entities\Database;


use Illuminate\Database\Eloquent\Model;

class Autorizacao extends Model
{
    protected $table = 'api.Autorizacao';
    public $timestamps = false;
    public static $snakeAttributes = false;
    protected $fillable = [
        'codigoPessoa',
        'idAppCliente',
        'hashAutorizacao',
        'dataAutorizacao',
        'urlRedirectAutorizacao',
    ];
}
