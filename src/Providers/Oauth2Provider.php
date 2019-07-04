<?php

namespace Girolando\Oauth2Layer\Providers;

use \Girolando\Oauth2Layer\Repositories\AccessTokenRepository;
use Girolando\Oauth2Layer\Repositories\AuthCodeRepository;
use \Girolando\Oauth2Layer\Repositories\ClientRepository;
use \Girolando\Oauth2Layer\Repositories\RefreshTokenRepository;
use \Girolando\Oauth2Layer\Repositories\ScopeRepository;
use \Girolando\Oauth2Layer\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\ResourceServer;

class Oauth2Provider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClientRepositoryInterface::class, function() {
            return new ClientRepository();
        });

        $this->app->bind(AccessTokenRepositoryInterface::class, function() {
            return new AccessTokenRepository();
        });

        $this->app->bind(ScopeRepositoryInterface::class, function() {
            return new ScopeRepository();
        });

        $this->app->bind(ResourceServer::class, function() {
            $accessTokenRespository = new AccessTokenRepository();
            $publicKey = base_path('public.key');
            return new ResourceServer($accessTokenRespository, $publicKey);
        });

        $this->app->bind(AuthorizationServer::class, function() {

            $clientRepository = new ClientRepository();
            $scopeRepository = new ScopeRepository();
            $accessTokenRepository = new AccessTokenRepository();
            $authCodeRepository = new AuthCodeRepository();
            $refreshTokenRepository = new RefreshTokenRepository();


            $privateKey = base_path('private.key');
            $publicKey = base_path('public.key');
            $userRepository = new UserRepository();
            $refreshTokenRepository = new RefreshTokenRepository();
            $intervaloPadrao = new \DateInterval('P12M');


            $server = new AuthorizationServer($clientRepository, $accessTokenRepository, $scopeRepository, $privateKey, $publicKey);
            $server->enableGrantType(new ClientCredentialsGrant(), $intervaloPadrao);
            $server->enableGrantType(new PasswordGrant($userRepository, $refreshTokenRepository), $intervaloPadrao);

            $authGrant = new AuthCodeGrant($authCodeRepository, $refreshTokenRepository, $intervaloPadrao);
            $authGrant->setRefreshTokenTTL(new \DateInterval('P12M'));
            
            
            $refreshGrant = new \League\OAuth2\Server\Grant\RefreshTokenGrant($refreshTokenRepository);
            $refreshGrant->setRefreshTokenTTL(new \DateInterval('P12M'));

            $server->enableGrantType($authGrant, $intervaloPadrao);
            $server->enableGrantType($refreshGrant, $intervaloPadrao);



            return $server;

        });

    }
}
