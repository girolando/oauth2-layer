<?php
/**
 * Created by PhpStorm.
 * User: andersonnunes
 * Date: 05/06/17
 * Time: 16:37
 */

namespace Girolando\Oauth2Layer\Repositories;


use Girolando\Oauth2Layer\Entities\AuthCodeEntity;
use Girolando\Oauth2Layer\Entities\Database\AppCliente;
use Girolando\Oauth2Layer\Entities\Database\Autorizacao;
use Girolando\Oauth2Layer\Entities\Database\Escopo;
use Girolando\Oauth2Layer\Entities\Database\Permissao;
use Girolando\Oauth2Layer\Exceptions\ClienteInvalidoException;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;

class AuthCodeRepository implements AuthCodeRepositoryInterface
{

    /**
     * Creates a new AuthCode
     *
     * @return AuthCodeEntityInterface
     */
    public function getNewAuthCode()
    {
        return new AuthCodeEntity();
    }

    /**
     * Persists a new auth code to permanent storage.
     *
     * @param AuthCodeEntityInterface $authCodeEntity
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        $client = (new AppCliente())
            ->newQuery()
            ->where('usuarioAppCliente', '=', $authCodeEntity->getClient()->getIdentifier())
            ->first();
        if(!$client) throw new ClienteInvalidoException();

        try{
            \DB::beginTransaction();
            $autorizacao = Autorizacao::create([
                'idAppCliente'          => $client->id,
                'codigoPessoa'          => $authCodeEntity->getUserIdentifier(),
                'hashAutorizacao'       => $authCodeEntity->getIdentifier(),
                'urlRedirectAutorizacao'    => $authCodeEntity->getRedirectUri()
            ]);
            foreach($authCodeEntity->getClient()->getRealEntity()->EscoposDisponiveis as $escopo) {
                Permissao::create([
                    'codigoPessoa'      => $authCodeEntity->getUserIdentifier(),
                    'idAppCliente'      => $client->id,
                    'idEscopo'          => $escopo->id,
                    'idAutorizacao'     => $autorizacao->id
                ]);
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }


        $authCodeEntity->getScopes();
    }

    /**
     * Revoke an auth code.
     *
     * @param string $codeId
     */
    public function revokeAuthCode($codeId)
    {
        $autorizacao = (new Autorizacao())->newQuery()->where('hashAutorizacao', '=', $codeId)->first();
        $autorizacao->statusAutorizacao = 0;
        $autorizacao->save();
    }

    /**
     * Check if the auth code has been revoked.
     *
     * @param string $codeId
     *
     * @return bool Return true if this code has been revoked
     */
    public function isAuthCodeRevoked($codeId)
    {
        $autorizacao = (new Autorizacao())->newQuery()->where('hashAutorizacao', '=', $codeId)->first();
        return ($autorizacao->statusAutorizacao == 0);
    }
}