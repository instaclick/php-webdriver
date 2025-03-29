<?php

/**
 * @copyright 2025 Anthon Pang
 * @license Apache-2.0
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver\Extension\WebAuthenticationAPI;

use WebDriver\AbstractWebDriver;

/**
 * Virtual Authenticator
 *
 * @method array credential($parameters) Add credential.
 * @method array uv($parameters) Set user verified.
 */
class VirtualAuthenticator extends AbstractWebDriver
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return [
            'credential' => ['POST'],
            'uv'         => ['POST'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function chainable()
    {
        return [
            'credentials' => 'credentials',
        ];
    }

    /**
     * Constructor
     *
     * @param string $url URL
     * @param string $id  Authenticator ID
     */
    public function __construct($url, $id)
    {
        parent::__construct($url . "/$id");
    }

    /**
     * Remove Virtual Authenticator: /session/:sessionId/webauthn/authenticator/:authenticatorId (DELETE)
     *
     * @return mixed
     */
    public function removeVirtualAuthenticator()
    {
        $result = $this->curl('DELETE', '');

        return $result['value'];
    }

    /**
     * Add credential: /session/:sessionId/webauthn/authenticator/:authenticatorId/credential (POST)
     *
     * @param array $parameters Credential Parameters {credentialId: ..., isResidentCredential: ..., rpId: ..., privateKey: ..., userHandle: ..., signCount: ..., largeBlob: ...}
     *
     * @return \WebDriver\Extension\WebAuthenticationAPI\Credential
     */
    public function addCredential($parameters)
    {
        $credentialId = $parameters['credentialId'];

        $this->curl('POST', '/credential', $parameters);

        return new Credential($this->url . '/credentials', $credentialId);
    }

    /**
     * Set user verified: /session/:sessionId/webauthn/authenticator/:authenticatorId/uv (POST)
     *
     * @param array|boolean $parameters Parameters {isUserVerified: ...}
     *
     * @return mixed
     */
    public function setUserVerified($parameters)
    {
        if (is_bool($parameters)) {
            $parameters = ['isUserVerified' => $parameters];
        }

        $result = $this->curl('POST', '/uv', $parameters);

        return $result['value'];
    }

    /**
     * Get Credentials object for chaining
     * - $authenticator->credentials()->method()
     * - $authenticator->credentials->method()
     *
     * @return \WebDriver\Extension\WebAuthenticationAPI\Credentials
     */
    protected function credentials()
    {
        return new Credentials($this->url . '/credentials');
    }
}
