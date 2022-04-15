<?php

/**
 * @copyright 2016 Gaetano Giunta
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Gaetano Giunta <giunta.gaetano@gmail.com>
 */

namespace WebDriver;

/**
 * WebDriverInterface interface
 *
 * @package WebDriver
 */
interface WebDriverInterface
{
    /**
     * New Session: /session (POST)
     * Get session object for chaining
     *
     * @param string $browserName          Preferred browser
     * @param array  $desiredCapabilities  Optional desired capabilities
     * @param array  $requiredCapabilities Optional required capabilities
     *
     * @return \WebDriver\Session
     */
    public function session($browserName = Browser::FIREFOX, $desiredCapabilities = null, $requiredCapabilities = null);
}
