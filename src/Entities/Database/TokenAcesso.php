<?php

namespace Girolando\Oauth2Layer\Entities\Database;

use Illuminate\Database\Eloquent\Model;

class TokenAcesso extends Model
{
    protected $table = 'api.TokenAcesso';
    public $timestamps = false;
    public static $snakeAttributes = false;
    protected $fillable = [
        'codigoPessoa',
        'idServico',
        'idAppCliente',
        'hashTokenAcesso',
        'consumidoTokenAcesso',
    ];
}
