<?php

/**
 * @copyright 2025 Anthon Pang
 * @license Apache-2.0
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver\Extension;

use WebDriver\AbstractWebDriver;
use WebDriver\Extension\WebAuthenticationAPI\VirtualAuthenticator;

/**
 * Web Authentication API
 *
 * @see https://www.w3.org/TR/webauthn-2/#sctn-automation
 */
class WebAuthenticationAPI extends AbstractWebDriver
{
    /**
     * Add virtual authenticator: /session/:sessionId/webauthn/authenticator (POST)
     *
     * @param mixed $parameters Authenticator Configuration {protocol: ... transport: ..., hasResidentKey: ..., hasUserVerification: ..., isUserConsenting: ..., isUserVerified: ..., extensions: ..., uvm: ...}
     *
     * @return mixed
     */
    public function addVirtualAuthenticator($parameters)
    {
        $result = $this->curl('POST', '', $parameters);

        $authenticatorId = $result['value'];

        return new VirtualAuthenticator($this->url, $authenticatorId);
    }
}
