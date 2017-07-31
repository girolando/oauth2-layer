<?php
/**
 * Created by PhpStorm.
 * User: andersonnunes
 * Date: 05/06/17
 * Time: 14:20
 */

namespace Girolando\Oauth2Layer\Repositories;


use \Girolando\Oauth2Layer\Entities\ClientEntity;
use Girolando\Oauth2Layer\Entities\Database\AppCliente;
use Girolando\Oauth2Layer\Exceptions\ClienteInvalidoException;
use Girolando\Oauth2Layer\Exceptions\ClienteNaoAutorizadoException;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{

    /**
     * Get a client.
     *
     * @param string $clientIdentifier The client's identifier
     * @param string $grantType The grant type used
     * @param null|string $clientSecret The client's secret (if sent)
     * @param bool $mustValidateSecret If true the client must attempt to validate the secret if the client
     *                                        is confidential
     *
     * @return ClientEntityInterface
     */
    public function getClientEntity($clientIdentifier, $grantType, $clientSecret = null, $mustValidateSecret = true)
    {
        $client = (new AppCliente())
            ->newQuery()
            ->where('usuarioAppCliente','=',$clientIdentifier);
        if($clientSecret)
            $client->where('secretAppCliente','=',$clientSecret);

        $client = $client->first();

        if(!$client) throw new ClienteInvalidoException();
        if(!$client->statusAppCliente) throw new ClienteNaoAutorizadoException();

        return (new ClientEntity())->setRealEntity($client->getModel());
    }
}