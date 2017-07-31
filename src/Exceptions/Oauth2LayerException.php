<?php
/**
 * Created by PhpStorm.
 * User: andersonnunes
 * Date: 05/07/17
 * Time: 14:38
 */

namespace Girolando\Oauth2Layer\Exceptions;


abstract class Oauth2LayerException extends \Exception
{

    abstract function errorType();

    public function __toString()
    {
        $payload = ['status' => 'error', 'error_type' => $this->errorType(), 'message' => $this->getMessage()];
        if(env('APP_DEBUG', false)) {
            $payload['stackTrace'] = $this->getTraceAsString();
        }

        return \GuzzleHttp\json_encode($payload);
    }

}