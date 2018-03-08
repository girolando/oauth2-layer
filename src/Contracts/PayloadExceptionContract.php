<?php
/**
 * Created by PhpStorm.
 * User: anderson
 * Date: 08/03/18
 * Time: 16:31
 */

namespace Girolando\Oauth2Layer\Contracts;


interface PayloadExceptionContract
{
    public function setPayload($payload);

    public function getPayload();
}