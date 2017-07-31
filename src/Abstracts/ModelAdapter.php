<?php
/**
 * Created by PhpStorm.
 * User: andersonnunes
 * Date: 05/07/17
 * Time: 11:35
 */

namespace Girolando\Oauth2Layer\Abstracts;


use Illuminate\Database\Eloquent\Model;

abstract class ModelAdapter
{
    protected $realEntity;

    public function setRealEntity(Model $model)
    {
        $this->realEntity = $model;
        return $this;
    }

    public function getRealEntity()
    {
        return $this->realEntity;
    }

    function __call($name, $arguments)
    {
        if(method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }
        return call_user_func_array([$this->realEntity, $name], $arguments);
    }
}