<?php

namespace Girolando\Oauth2Layer\Entities\Database;

use Illuminate\Database\Eloquent\Model;

class Escopo extends Model
{
    protected $table = 'api.Escopo';
    public $timestamps = false;
    public static $snakeAttributes = false;
    protected $fillable = [
        'idAppServidor',
        'nomeEscopo',
        'bitGeralEscopo',
    ];


    public function AppServidor()
    {
        return $this->belongsTo(AppServidor::class, 'idAppServidor');
    }
}
