<?php

/**
 * @copyright 2012 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\AppCacheStatus class
 *
 * @package WebDriver
 *
 * @deprecated by W3C WebDriver
 */
final class AppCacheStatus
{
    /**
     * Application cache status
     *
     * @see https://github.com/SeleniumHQ/selenium/blob/trunk/java/src/org/openqa/selenium/html5/AppCacheStatus.java
     */
    const UNCACHED     = 0;
    const IDLE         = 1;
    const CHECKING     = 2;
    const DOWNLOADING  = 3;
    const UPDATE_READY = 4;
    const OBSOLETE     = 5;
}
