<?php

namespace Girolando\Oauth2Layer\Entities\Database;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $table = 'dbo.Pessoa';
    public $timestamps = false;
    public static $snakeAttributes = false;
    protected $primaryKey = 'codigoPessoa';
    protected $fillable = [
        'cpfPessoa',
        'nomePessoa',
        'emailPessoa',
        'loginPessoa',
        'senhaPessoa',
        'qtdAcessosPessoa',
        'alteraSenhaPessoa',
        'statusPessoa',
        'webAssociadoPessoa',
        'ultimoAcessoPessoa',
        'usuarioAdPessoa',
        'codigoSetor',
        'codCfo'
    ];
}
