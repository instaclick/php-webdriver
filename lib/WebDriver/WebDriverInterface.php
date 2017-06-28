<?php

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
     * @param array|string $requiredCapabilities Required capabilities (or browser name)
     * @param array        $desiredCapabilities  Desired capabilities
     *
     * @return \WebDriver\Session
     */
    public function session($requiredCapabilities = Browser::FIREFOX, $desiredCapabilities = array());

    /**
     * Get list of currently active sessions
     *
     * @return array an array of \WebDriver\Session objects
     */
    public function sessions();
}
