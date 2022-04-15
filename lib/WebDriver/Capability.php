<?php

/**
 * @copyright 2011 Fabrizio Branca
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Fabrizio Branca <mail@fabrizio-branca.de>
 */

namespace WebDriver;

/**
 * WebDriver\Capability class
 *
 * @package WebDriver
 */
final class Capability
{
    /**
     * Desired capabilities
     *
     * @see https://w3c.github.io/webdriver/webdriver-spec.html#capabilities
     * @see https://github.com/SeleniumHQ/selenium/blob/trunk/java/src/org/openqa/selenium/remote/CapabilityType.java
     */
    const BROWSER_NAME                = 'browserName';
    const BROWSER_VERSION             = 'browserVersion';
    const PLATFORM_NAME               = 'platformName';
    const PLATFORM_VERSION            = 'platformVersion';
    const ACCEPT_SSL_CERTS            = 'acceptSslCerts';
    const PAGE_LOAD_STRATEGY          = 'pageLoadStrategy';
    const PROXY                       = 'proxy';
    const TIMEOUTS                    = 'timeouts';

    // legacy JSON Wire Protocol
    const VERSION                     = 'version';
    const PLATFORM                    = 'platform';
    const JAVASCRIPT_ENABLED          = 'javascriptEnabled';
    const TAKES_SCREENSHOT            = 'takesScreenshot';
    const HANDLES_ALERTS              = 'handlesAlerts';
    const DATABASE_ENABLED            = 'databaseEnabled';
    const LOCATION_CONTEXT_ENABLED    = 'locationContextEnabled';
    const APPLICATION_CACHE_ENABLED   = 'applicationCacheEnabled';
    const BROWSER_CONNECTION_ENABLED  = 'browserConnectionEnabled';
    const CSS_SELECTORS_ENABLED       = 'cssSelectorsEnabled';
    const WEB_STORAGE_ENABLED         = 'webStorageEnabled';
    const ROTATABLE                   = 'rotatable';
    const NATIVE_EVENTS               = 'nativeEvents';
    const UNEXPECTED_ALERT_BEHAVIOUR  = 'unexpectedAlertBehaviour';
    const ELEMENT_SCROLL_BEHAVIOR     = 'elementScrollBehavior';
    const STRICT_FILE_INTERACTABILITY = 'strictFileInteractability';
    const UNHANDLED_PROMPT_BEHAVIOR   = 'unhandlePromptBehavior';

    /**
     * Proxy types
     *
     * @see https://w3c.github.io/webdriver/webdriver-spec.html#proxy
     */
    const AUTODETECT = 'autodetect';
    const MANUAL     = 'manual';
    const NO_PROXY   = 'noproxy';
    const PAC        = 'pac';
    const SYSTEM     = 'system';

    // legacy JSON Wire Protocol
    const DIRECT     = 'direct';
}
