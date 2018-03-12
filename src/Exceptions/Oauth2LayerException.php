<?php
/**
 * Created by PhpStorm.
 * User: andersonnunes
 * Date: 05/07/17
 * Time: 14:38
 */

namespace Girolando\Oauth2Layer\Exceptions;


use Girolando\Oauth2Layer\Contracts\PayloadExceptionContract;
use Girolando\Oauth2Layer\Traits\PayloadExceptionTrait;

abstract class Oauth2LayerException extends \Exception implements PayloadExceptionContract
{
    use PayloadExceptionTrait;

    abstract function errorType();

    public function __toString()
    {
        $payload = ['status' => 'error', 'error_type' => $this->errorType(), 'message' => $this->getMessage(), 'payload' => $this->getPayload()];
        if(env('APP_DEBUG', false)) {
            $payload['stackTrace'] = $this->getTraceAsString();
        }


        return \GuzzleHttp\json_encode($payload);
    }

}
