<?php
/**
 * Created by PhpStorm.
 * User: anderson
 * Date: 08/03/18
 * Time: 16:38
 */

namespace Girolando\Oauth2Layer\Traits;


trait PayloadExceptionTrait
{
    protected $payload;

    public function setPayload($payload)
    {
        $this->payload = $payload;
        return $this;
    }


    public function getPayload()
    {
        return $this->payload;
    }
}