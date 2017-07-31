<?php
/**
 * Created by PhpStorm.
 * User: andersonnunes
 * Date: 05/06/17
 * Time: 16:23
 */

namespace Girolando\Oauth2Layer\Repositories;


use Girolando\Oauth2Layer\Entities\Database\RefreshTokenAcesso;
use Girolando\Oauth2Layer\Entities\Database\TokenAcesso;
use Girolando\Oauth2Layer\Entities\RefreshTokenEntity;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{

    /**
     * Creates a new refresh token
     *
     * @return RefreshTokenEntityInterface
     */
    public function getNewRefreshToken()
    {
        return new RefreshTokenEntity();
    }

    /**
     * Create a new refresh token_name.
     *
     * @param RefreshTokenEntityInterface $refreshTokenEntity
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        $tokenAcesso = (new TokenAcesso())
            ->newQuery()
            ->where('hashTokenAcesso', 'like', $refreshTokenEntity->getAccessToken()->getIdentifier())
            ->first();
        RefreshTokenAcesso::create([
            'idTokenAcesso'                     => $tokenAcesso->id,
            'hashRefreshTokenAcesso'            => $refreshTokenEntity->getIdentifier(),
            'expiracaoRefreshTokenAcesso'       => $refreshTokenEntity->getExpiryDateTime()->format('Y-m-d H:i:s'),
        ]);
        return $refreshTokenEntity;
    }

    /**
     * Revoke the refresh token.
     *
     * @param string $tokenId
     */
    public function revokeRefreshToken($tokenId)
    {
        $refreshToken = $this->getTokenByHash($tokenId);
        if(!$refreshToken) return;
        $refreshToken->expiracaoRefreshTokenAcesso = (new \DateTime())->sub(new \DateInterval('PT1M'))->format('Y-m-d H:i:s');
        $refreshToken->save();
    }

    /**
     * Check if the refresh token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        return false;
    }

    private function getTokenByHash($hash)
    {
        return (new RefreshTokenAcesso())->newQuery()->where('hashRefreshTokenAcesso','like', $hash)->first();
    }
}