<?php

/**
 * Copyright 2011-2021 Fabrizio Branca. All Rights Reserved.
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
 * WebDriver\Browser class
 *
 * @package WebDriver
 */
final class Browser
{
    /**
     * Check browser names used in static functions in the selenium source:
     * @see https://github.com/SeleniumHQ/selenium/blob/trunk/java/client/src/org/openqa/selenium/remote/BrowserType.java
     *
     * Also check
     * @see http://code.google.com/p/selenium/wiki/JsonWireProtocol#Capabilities_JSON_Object
     */
    const ANDROID           = 'android';
    const CHROME            = 'chrome';
    const EDGE              = 'edge';
    const EDGEHTML          = 'EdgeHTML';
    const FIREFOX           = 'firefox';
    const HTMLUNIT          = 'htmlunit';
    const IE                = 'internet explorer';
    const INTERNET_EXPLORER = 'internet explorer';
    const IPHONE            = 'iPhone';
    const IPAD              = 'iPad';
    const MSEDGE            = 'MicrosoftEdge';
    const OPERA             = 'opera';
    const OPERA_BLINK       = 'operablink';
    const PHANTOMJS         = 'phantomjs';
    const SAFARI            = 'safari';
}
