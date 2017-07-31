<?php
/**
 * Created by PhpStorm.
 * User: andersonnunes
 * Date: 05/06/17
 * Time: 14:17
 */

namespace Girolando\Oauth2Layer\Repositories;


use Girolando\Oauth2Layer\Abstracts\ModelAdapter;
use \Girolando\Oauth2Layer\Entities\AccessTokenEntity;
use Girolando\Oauth2Layer\Entities\Database\TokenAcesso;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{

    /**
     * Create a new access token
     *
     * @param ClientEntityInterface $clientEntity
     * @param ScopeEntityInterface[] $scopes
     * @param mixed $userIdentifier
     *
     * @return AccessTokenEntityInterface
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessTokenEntity = new AccessTokenEntity();
        $accessTokenEntity->setClient($clientEntity);
        foreach($scopes as $scope) $accessTokenEntity->addScope($scope);
        if($userIdentifier) {
            $accessTokenEntity->setUserIdentifier($userIdentifier);
        }
        return $accessTokenEntity;
    }

    /**
     * Persists a new access token to permanent storage.
     *
     * @param AccessTokenEntityInterface $accessTokenEntity
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $tokensAntigos = (new TokenAcesso())
            ->newQuery()
            ->where('codigoPessoa','=', $accessTokenEntity->getUserIdentifier())
            ->where('idAppCliente','=', $accessTokenEntity->getClient()->getIdentifier())
            ->where('expiracaoTokenAcesso','=', 0)
            ->get();
        foreach($tokensAntigos as $tokenAntigo) {
            $tokenAntigo->consumidoTokenAcesso = 1;
            $tokenAntigo->save();
        }
        $tokenAcesso = new TokenAcesso();
        $tokenAcesso->hashTokenAcesso = $accessTokenEntity->getIdentifier();
        $tokenAcesso->codigoPessoa = $accessTokenEntity->getUserIdentifier();
        $tokenAcesso->idAppCliente = $accessTokenEntity->getClient()->getRealEntity()->id;
        $tokenAcesso->consumidoTokenAcesso = 0;
        $tokenAcesso->expiracaoTokenAcesso = $accessTokenEntity->getExpiryDateTime()->format('Y-m-d H:i:s');
        $tokenAcesso->save();

        return $accessTokenEntity;
    }

    /**
     * Revoke an access token.
     *
     * @param string $tokenId
     */
    public function revokeAccessToken($tokenId)
    {
        $token = $this->getTokenByHash($tokenId);
        if(!$token) return;

        $token->consumidoTokenAcesso = 1;
        $token->save();
    }

    /**
     * Check if the access token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isAccessTokenRevoked($tokenId)
    {
        $token = $this->getTokenByHash($tokenId);
        $hj = new \DateTime();
        if(!$token || $token->consumidoTokenAcesso == 1) return true;
        return false;
    }


    private function getTokenByHash($hash)
    {
        return (new TokenAcesso())->newQuery()->where('hashTokenAcesso','like', $hash)->first();
    }
}