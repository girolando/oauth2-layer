<?php
/**
 * Created by PhpStorm.
 * User: anderson
 * Date: 25/07/17
 * Time: 09:12
 */

namespace Girolando\Oauth2Layer\Exceptions;


class EscopoInvalidoexception extends Oauth2LayerException
{

    function errorType()
    {
        return 'ESCOPO_INVALIDO';
    }
}