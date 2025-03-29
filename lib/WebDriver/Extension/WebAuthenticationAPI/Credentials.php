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
 * Virtual Authenticator Credentials
 *
 * @method array credentials() Get credentials.
 */
class Credentials extends AbstractWebDriver
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return [
            'credentials' => ['GET'],
        ];
    }

    /**
     * Get Credentials: /session/:sessionId/webauthn/authenticator/:authenticatorId/credentials (GET)
     *
     * @return mixed
     */
    public function getCredentials()
    {
        $result = $this->curl('GET', '');

        return $result['value'];
    }

    /**
     * Remove All Credentials: /session/:sessionId/webauthn/authenticator/:authenticatorId/credentials (DELETE)
     *
     * @return mixed
     */
    public function removeCredentials()
    {
        $result = $this->curl('DELETE', '');

        return $result['value'];
    }
}
