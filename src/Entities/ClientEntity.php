<?php
/**
 * Created by PhpStorm.
 * User: andersonnunes
 * Date: 05/06/17
 * Time: 16:21
 */

namespace Girolando\Oauth2Layer\Entities;


use Girolando\Oauth2Layer\Abstracts\ModelAdapter;
use League\OAuth2\Server\Entities\ClientEntityInterface;

class ClientEntity extends ModelAdapter implements ClientEntityInterface
{

    /**
     * Get the client's identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->realEntity->usuarioAppCliente;
    }

    /**
     * Get the client's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->realEntity->nomeAppCliente;
    }

    /**
     * Returns the registered redirect URI (as a string).
     *
     * Alternatively return an indexed array of redirect URIs.
     *
     * @return string|string[]
     */
    public function getRedirectUri()
    {
        return $this->realEntity->siteAppCliente;
    }
}