<?php
/**
 * Created by PhpStorm.
 * User: anderson
 * Date: 25/07/17
 * Time: 10:35
 */

namespace Girolando\Oauth2Layer\Exceptions;


class CredenciaisInvalidasException extends Oauth2LayerException
{

    function errorType()
    {
        return 'CREDENCIAIS_INVALIDAS';
    }
}