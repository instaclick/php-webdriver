<?php

/**
 * Copyright 2011-2022 Fabrizio Branca. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package WebDriver
 *
 * @author Fabrizio Branca <mail@fabrizio-branca.de>
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\Capability class
 *
 * @package WebDriver
 */
class Capability
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
