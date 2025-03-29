<?php

/**
 * @copyright 2011 Fabrizio Branca
 * @license Apache-2.0
 *
 * @author Fabrizio Branca <mail@fabrizio-branca.de>
 */

namespace WebDriver;

/**
 * WebDriver\Capability class
 */
final class Capability
{
    /**
     * Desired capabilities
     *
     * @see https://w3c.github.io/webdriver/webdriver-spec.html#capabilities
     * @see https://github.com/SeleniumHQ/selenium/blob/trunk/java/src/org/openqa/selenium/remote/CapabilityType.java
     */
    const ACCEPT_INSECURE_CERTS       = 'acceptInsecureCerts';
    const BROWSER_NAME                = 'browserName';
    const BROWSER_VERSION             = 'browserVersion';
    const PAGE_LOAD_STRATEGY          = 'pageLoadStrategy';
    const PLATFORM_NAME               = 'platformName';
    const PROXY                       = 'proxy';
    const SET_WINDOW_RECT             = 'setWindowRect';
    const STRICT_FILE_INTERACTABILITY = 'strictFileInteractability';
    const TIMEOUTS                    = 'timeouts';
    const UNHANDLED_PROMPT_BEHAVIOR   = 'unhandlePromptBehavior';
    const USER_AGENT                  = 'userAgent';

    // obsolete or legacy JSON Wire Protocol
    const ACCEPT_SSL_CERTS            = 'acceptSslCerts';
    const APPLICATION_CACHE_ENABLED   = 'applicationCacheEnabled';
    const BROWSER_CONNECTION_ENABLED  = 'browserConnectionEnabled';
    const CSS_SELECTORS_ENABLED       = 'cssSelectorsEnabled';
    const DATABASE_ENABLED            = 'databaseEnabled';
    const ELEMENT_SCROLL_BEHAVIOR     = 'elementScrollBehavior';
    const HANDLES_ALERTS              = 'handlesAlerts';
    const JAVASCRIPT_ENABLED          = 'javascriptEnabled';
    const LOCATION_CONTEXT_ENABLED    = 'locationContextEnabled';
    const NATIVE_EVENTS               = 'nativeEvents';
    const PLATFORM                    = 'platform';
    const PLATFORM_VERSION            = 'platformVersion';
    const ROTATABLE                   = 'rotatable';
    const TAKES_SCREENSHOT            = 'takesScreenshot';
    const UNEXPECTED_ALERT_BEHAVIOUR  = 'unexpectedAlertBehaviour';
    const VERSION                     = 'version';
    const WEB_STORAGE_ENABLED         = 'webStorageEnabled';
}
