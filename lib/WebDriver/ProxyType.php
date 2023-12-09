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
 * WebDriver\ProxyType class
 *
 * @package WebDriver
 */
final class ProxyType
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
}
