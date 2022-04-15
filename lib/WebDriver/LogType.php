<?php

/**
 * @copyright 2014 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\LogType class
 *
 * @package WebDriver
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
    const PROFILER    = 'driver';
    const SERVER      = 'server';
}
