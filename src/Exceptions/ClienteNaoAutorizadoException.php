<?php
/**
 * Created by PhpStorm.
 * User: andersonnunes
 * Date: 05/07/17
 * Time: 14:21
 */

namespace Girolando\Oauth2Layer\Exceptions;


class ClienteNaoAutorizadoException extends Oauth2LayerException
{

    function errorType()
    {
        return 'ERRO_CLIENTE_NAO_AUTORIZADO';
    }
}