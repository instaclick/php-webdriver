<?php
/**
 * Copyright 2011-2017 Fabrizio Branca. All Rights Reserved.
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
     * @see https://github.com/SeleniumHQ/selenium/blob/trunk/java/src/org/openqa/selenium/remote/Browser.java
     */
    const CHROME              = 'chrome';
    const EDGE                = 'MicrosoftEdge';
    const FIREFOX             = 'firefox';
    const HTMLUNIT            = 'htmlunit';
    const IE                  = 'internet explorer';
    const OPERA               = 'opera';
    const SAFARI              = 'safari';
    const SAFARI_TECH_PREVIEW = 'Safari Technology Preview';

    /**
     * @see https://github.com/SeleniumHQ/selenium/blob/trunk/javascript/webdriver/capabilities.js
     * @deprecated
     */
    const ANDROID             = 'android';
    const EDGEHTML            = 'EdgeHTML';
    const INTERNET_EXPLORER   = 'internet explorer';
    const IPAD                = 'iPad';
    const IPHONE              = 'iPhone';
    const MSEDGE              = 'MicrosoftEdge';
    const OPERA_BLINK         = 'operablink';
    const PHANTOM_JS          = 'phantomjs';
    const PHANTOMJS           = 'phantomjs';
}
