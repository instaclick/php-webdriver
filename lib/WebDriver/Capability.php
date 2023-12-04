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
    const ACCEPT_INSECURE_CERTS       = 'acceptInsecureCerts';
    const BROWSER_NAME                = 'browserName';
    const BROWSER_VERSION             = 'browserVersion';
    const ENABLE_DOWNLOADS            = 'enableDownloads';
    const PLATFORM_NAME               = 'platformName';
    const PLATFORM_VERSION            = 'platformVersion';
    const PAGE_LOAD_STRATEGY          = 'pageLoadStrategy';
    const PROXY                       = 'proxy';
    const SET_WINDOW_RECT             = 'setWindowRect';
    const STRICT_FILE_INTERACTABILITY = 'strictFileInteractability';
    const TIMEOUTS                    = 'timeouts';
    const UNHANDLED_PROMPT_BEHAVIOR   = 'unhandlePromptBehavior';
}
