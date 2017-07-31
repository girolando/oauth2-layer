<?php

namespace Girolando\Oauth2Layer\Entities\Database;

use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    protected $table = 'api.Permissao';
    public $timestamps = false;
    public static $snakeAttributes = false;
    protected $fillable = [
        'codigoPessoa',
        'idEscopo',
        'idAppCliente',
        'idAutorizacao',
    ];
}
