<?php

namespace Girolando\Oauth2Layer\Entities\Database;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    protected $table = 'api.Servicos';
    public $timestamps = false;
    public static $snakeAttributes = false;
    protected $fillable = [
        'nomeServico',
        'routeServico',
        'isPersonalServico',
        'idAppServidor',
        'codigoModulo',
    ];
}
