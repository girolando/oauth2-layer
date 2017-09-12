<?php
/**
 * Created by PhpStorm.
 * User: andersonnunes
 * Date: 05/06/17
 * Time: 16:37
 */

namespace Girolando\Oauth2Layer\Entities;


use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

class AuthCodeEntity implements AuthCodeEntityInterface
{

    protected $redirectUrl;
    protected $identifier;
    protected $expiryTime;
    protected $userIdentifier;
    protected $client;
    protected $scopes = [];

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUrl;
    }

    /**
     * @param string $uri
     */
    public function setRedirectUri($uri)
    {
        $this->redirectUrl = $uri;
    }

    /**
     * Get the token's identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set the token's identifier.
     *
     * @param $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Get the token's expiry date time.
     *
     * @return \DateTime
     */
    public function getExpiryDateTime()
    {
        return $this->expiryTime;
    }

    /**
     * Set the date time when the token expires.
     *
     * @param \DateTime $dateTime
     */
    public function setExpiryDateTime(\DateTime $dateTime)
    {
        $this->expiryTime = $dateTime;
    }

    /**
     * Set the identifier of the user associated with the token.
     *
     * @param string|int $identifier The identifier of the user
     */
    public function setUserIdentifier($identifier)
    {
        $this->userIdentifier = $identifier;
    }

    /**
     * Get the token user's identifier.
     *
     * @return string|int
     */
    public function getUserIdentifier()
    {
        return $this->userIdentifier;
    }

    /**
     * Get the client that the token was issued to.
     *
     * @return ClientEntityInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set the client that the token was issued to.
     *
     * @param ClientEntityInterface $client
     */
    public function setClient(ClientEntityInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Associate a scope with the token.
     *
     * @param ScopeEntityInterface $scope
     */
    public function addScope(ScopeEntityInterface $scope)
    {
        if(!$this->scopes) {
            $this->scopes = [];
        }
        $this->scopes[] = $scope;
        return $scope;
    }

    /**
     * Return an array of scopes associated with the token.
     *
     * @return ScopeEntityInterface[]
     */
    public function getScopes()
    {
        return $this->scopes;
    }
}