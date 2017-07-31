<?php

namespace Girolando\Oauth2Layer\Entities\Database;

use Illuminate\Database\Eloquent\Model;

class AppClienteEscopo extends Model
{
    protected $table = 'api.AppClienteEscopo';
    public $timestamps = false;
    public static $snakeAttributes = false;
    protected $fillable = [
        'idAppCliente',
        'idEscopo'
    ];


    public function AppCliente()
    {
        return $this->belongsTo(AppCliente::class, 'idAppCliente');
    }

    public function Escopo()
    {
        return $this->belongsTo(Escopo::class, 'idEscopo');
    }
}
