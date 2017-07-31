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

        /*$this->app->bind(ServerRequest::class, function() {


            $server = app(AuthorizationServer::class);

            $server->enableGrantType(new ClientCredentialsGrant(), $intervaloPadrao);
            $server->enableGrantType(new PasswordGrant($userRepository, $refreshTokenRepository), $intervaloPadrao);

            $this->app->instance(AuthorizationServer::class, $server);

            //HTTP PSR-7:
            $normalRequest = \Illuminate\Http\Request::capture();
            //$normalRequest = app(\Illuminate\Http\Request::class);

            $requestInstance = new ServerRequest($normalRequest->getMethod(), $normalRequest->getUri(), $normalRequest->headers->all(), $normalRequest->getContent());
            dd('cheogu aki', $normalRequest->all(), $requestInstance->getParsedBody(), $normalRequest->getContent()); //a $normalRequest tem seus dados exibidos normalmente.
            //Já a $requestInstance, que é uma instancia da ServerRequest, mesmo eu tendo passado o getContent pro construtor dela, vem vazia.
            return $requestInstance;
        });*/

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
            $intervaloPadrao = new \DateInterval('PT1H');


            $server = new AuthorizationServer($clientRepository, $accessTokenRepository, $scopeRepository, $privateKey, $publicKey);
            $server->enableGrantType(new ClientCredentialsGrant(), $intervaloPadrao);
            $server->enableGrantType(new PasswordGrant($userRepository, $refreshTokenRepository), $intervaloPadrao);

            $authGrant = new AuthCodeGrant($authCodeRepository, $refreshTokenRepository, new \DateInterval('PT30M'));
            $authGrant->setRefreshTokenTTL(new \DateInterval('P30D'));
            $server->enableGrantType($authGrant, $intervaloPadrao);


            return $server;

        });

    }
}
