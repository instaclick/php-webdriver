<?php

/**
 * @copyright 2025 Anthon Pang
 * @license Apache-2.0
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\Proxy class
 */
final class Proxy
{
    /**
     * Proxy types
     *
     * @see https://w3c.github.io/webdriver/webdriver-spec.html#proxy
     */
    const AUTODETECT = 'autodetect';
    const DIRECT     = 'direct';
    const MANUAL     = 'manual';
    const PAC        = 'pac';
    const SYSTEM     = 'system';

    /**
     * Proxy type: PAC
     */
    const PROXY_AUTO_CONFIG_URL = 'proxyAutoconfigUrl';

    /**
     * Proxy type: MANUAL
     */
    const FTP_PROXY     = 'ftpProxy';
    const HTTP_PROXY    = 'httpProxy';
    const NO_PROXY      = 'noProxy';
    const SSL_PROXY     = 'sslProxy';
    const SOCKS_PROXY   = 'socksProxy';
    const SOCKS_VERSION = 'socksVersion';
}
