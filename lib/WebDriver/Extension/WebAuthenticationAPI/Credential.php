<?php

/**
 * @copyright 2023 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver\Extension\WebAuthenticationAPI;

use WebDriver\AbstractWebDriver;

/**
 * Virtual Authenticator Credential
 *
 * @package WebDriver
 */
class Credential extends AbstractWebDriver
{
    /**
     * Constructor
     *
     * @param string $url URL
     * @param string $id  Credential ID
     */
    public function __construct($url, $id)
    {
        parent::__construct($url . "/$id");
    }

    /**
     * Remove Credential: /session/:sessionId/webauthn/authenticator/:authenticatorId/credentials/:credentialId (DELETE)
     *
     * @return mixed
     */
    public function removeCredential()
    {
        $result = $this->curl('DELETE', '');

        return $result['value'];
    }
}
