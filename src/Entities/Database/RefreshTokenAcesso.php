<?php

namespace Girolando\Oauth2Layer\Entities\Database;

use Illuminate\Database\Eloquent\Model;

class RefreshTokenAcesso extends Model
{
    protected $table = 'api.RefreshTokenAcesso';
    public $timestamps = false;
    public static $snakeAttributes = false;
    protected $fillable = [
        'hashRefreshTokenAcesso',
        'expiracaoRefreshTokenAcesso',
        'idTokenAcesso',
    ];
}
