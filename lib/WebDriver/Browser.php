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
 * WebDriver\Browser class
 *
 * @package WebDriver
 */
final class Browser
{
    /**
     * Check browser names used in static functions in the selenium source:
     * @see https://github.com/SeleniumHQ/selenium/blob/trunk/java/src/org/openqa/selenium/remote/BrowserType.java
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
