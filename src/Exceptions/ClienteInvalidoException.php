<?php
/**
 * Created by PhpStorm.
 * User: andersonnunes
 * Date: 05/07/17
 * Time: 14:32
 */

namespace Girolando\Oauth2Layer\Exceptions;


class ClienteInvalidoException extends Oauth2LayerException
{

    function errorType()
    {
        return 'ERRO_CLIENTE_INVALIDO';
    }
}