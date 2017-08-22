<?php

namespace Girolando\Oauth2Layer\Entities\Database;

use Illuminate\Database\Eloquent\Model;

class AppCliente extends Model
{
    protected $table = 'api.AppCliente';
    public $timestamps = false;
    public static $snakeAttributes = false;
    protected $fillable = [
        'nomeAppCliente',
        'siteAppCliente',
        'statusAppCliente',
        'usuarioAppCliente',
        'secretAppCliente',
        'classAppCliente',
        'descAppCliente',
    ];
    protected $appends = [
        'urlImagem',
    ];


    public function EscoposDisponiveis()
    {
        return $this->belongsToMany(Escopo::class, 'api.AppClienteEscopo', 'idAppCliente', 'idEscopo');
    }


    public function getUrlImagemAttribute()
    {

    }
}
