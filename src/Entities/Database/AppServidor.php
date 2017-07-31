<?php

namespace Girolando\Oauth2Layer\Entities\Database;

use Illuminate\Database\Eloquent\Model;

class AppServidor extends Model
{
    protected $table = 'api.AppServidor';
    public $timestamps = false;
    public static $snakeAttributes = false;
    protected $fillable = [
        'nomeAppServidor',
        'descAppServidor',
        'onlineAppServidor',
    ];
}
