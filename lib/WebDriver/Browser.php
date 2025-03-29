<?php

/**
 * @copyright 2011 Fabrizio Branca
 * @license Apache-2.0
 *
 * @author Fabrizio Branca <mail@fabrizio-branca.de>
 */

namespace WebDriver;

/**
 * WebDriver\Browser class
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
}
