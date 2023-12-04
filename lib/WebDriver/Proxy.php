<?php

/**
 * @copyright 2023 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\Proxy class
 *
 * @package WebDriver
 */
final class Proxy
{
    /**
     * Proxy configuration
     *
     * @see https://w3c.github.io/webdriver/webdriver-spec.html#proxy
     */
    const PROXY_TYPE           = 'proxyType';
    const PROXY_AUTOCONFIG_URL = 'proxyAutoconfigUrl';
    const FTP_PROXY            = 'ftpProxy';
    const HTTP_PROXY           = 'httpProxy';
    const NO_PROXY             = 'noProxy';
    const SSL_PROXY            = 'sslProxy';
    const SOCKS_PROXY          = 'socksProxy';
    const SOCKS_VERSION        = 'socksVersion';
}
