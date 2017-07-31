<?php
/**
 * Created by PhpStorm.
 * User: andersonnunes
 * Date: 05/06/17
 * Time: 16:27
 */

namespace Girolando\Oauth2Layer\Repositories;


use Girolando\Oauth2Layer\Entities\Database\AppCliente;
use Girolando\Oauth2Layer\Entities\Database\Escopo;
use Girolando\Oauth2Layer\Entities\Database\Permissao;
use \Girolando\Oauth2Layer\Entities\ScopeEntity;
use Girolando\Oauth2Layer\Exceptions\ClienteInvalidoException;
use Girolando\Oauth2Layer\Exceptions\EscopoInvalidoexception;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Grant\GrantTypeInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

class ScopeRepository implements ScopeRepositoryInterface
{

    /**
     * Return information about a scope.
     *
     * @param string $identifier The scope identifier
     *
     * @return ScopeEntityInterface
     */
    public function getScopeEntityByIdentifier($identifier)
    {
        $escopo = new ScopeEntity();
        $escopo->nomeEscopo = $identifier;
        return $escopo;
    }

    /**
     * Given a client, grant type and optional user identifier validate the set of scopes requested are valid and optionally
     * append additional scopes or remove requested scopes.
     *
     * @param ScopeEntityInterface[] $scopes
     * @param string $grantType
     * @param ClientEntityInterface $clientEntity
     * @param null|string $userIdentifier
     *
     * @return ScopeEntityInterface[]
     */
    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    )
    {
        $client = (new AppCliente())->newQuery()->where('usuarioAppCliente', '=', $clientEntity->getIdentifier())->first();
        if(!$client) throw new ClienteInvalidoException();
        $client = $client->getModel();

        $retorno = [];
        foreach($scopes as $scope) {
            if(in_array($scope->getIdentifier(), $retorno)) continue;
            $escopo = (new Escopo())->newQuery()->where('nomeEscopo', '=', str_replace('"', '', $scope->getIdentifier()))->first();
            if(!$escopo) throw new EscopoInvalidoexception('tentando pegar o escopo: ' . $scope->getIdentifier());
            $escopo = $escopo->getModel();

            $permissao = (new Permissao())
                ->newQuery()
                ->where('idAppCliente','=', $client->id)
                ->where('idEscopo', '=', $escopo->id)
                ->where('codigoPessoa', '=', $userIdentifier)
                ->first();
            if($permissao)
                $retorno[] = $scope->getIdentifier();
        }

        $escoposParaRetorno = [];
        foreach($retorno as $nomeEscopo) {
            $escopo = new ScopeEntity();
            $escopo->nomeEscopo = $nomeEscopo;
            $escoposParaRetorno[] = $escopo;
        }
        //verifico se o cliente possui permissão pra acessar esse escopo
        return $escoposParaRetorno;
    }
}