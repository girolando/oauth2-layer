<?php
/**
 * Created by PhpStorm.
 * User: andersonnunes
 * Date: 05/06/17
 * Time: 16:42
 */

namespace Girolando\Oauth2Layer\Entities;


use Girolando\Oauth2Layer\Abstracts\ModelAdapter;
use League\OAuth2\Server\Entities\UserEntityInterface;

class UserEntity extends ModelAdapter implements UserEntityInterface
{

    /**
     * Return the user's identifier.
     *
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->realEntity->codigoPessoa;
    }
}