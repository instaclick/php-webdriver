<?php

/**
 * @copyright 2014 Anthon Pang
 * @license Apache-2.0
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver\Extension\Selenium;

/**
 * WebDriver\LogType class
 */
final class LogType
{
    /**
     * Log Type
     *
     * @see https://github.com/SeleniumHQ/selenium/blob/trunk/java/src/org/openqa/selenium/logging/LogType.java
     */
    const BROWSER     = 'browser';
    const CLIENT      = 'client';
    const DRIVER      = 'driver';
    const PERFORMANCE = 'performance';
    const PROFILER    = 'profiler';
    const SERVER      = 'server';
}
