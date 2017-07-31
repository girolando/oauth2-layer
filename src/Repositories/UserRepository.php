<?php
/**
 * Created by PhpStorm.
 * User: andersonnunes
 * Date: 05/06/17
 * Time: 16:41
 */

namespace Girolando\Oauth2Layer\Repositories;


use Girolando\Oauth2Layer\Entities\Database\Pessoa;
use \Girolando\Oauth2Layer\Entities\UserEntity;
use Girolando\Oauth2Layer\Exceptions\CredenciaisInvalidasException;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    /**
     * Get a user entity.
     *
     * @param string $username
     * @param string $password
     * @param string $grantType The grant type used
     * @param ClientEntityInterface $clientEntity
     *
     * @return UserEntityInterface
     */
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    )
    {
        $pessoa = (new Pessoa())
            ->newQuery()
            ->where('loginPessoa', '=', $username)
            ->where('senhaPessoa', '=', strtoupper(md5($password)))
            ->first();
        if(!$pessoa) throw new CredenciaisInvalidasException();

        $retorno = new UserEntity();
        $retorno->setRealEntity($pessoa);
        return $retorno;
    }
}