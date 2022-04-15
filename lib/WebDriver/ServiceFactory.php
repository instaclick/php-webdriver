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
 * WebDriver\ServiceFactory class
 *
 * A service factory
 *
 * @package WebDriver
 */
class ServiceFactory
{
    /**
     * singleton
     *
     * @var \WebDriver\ServiceFactory
     */
    private static $instance;

    /**
     * @var array
     */
    protected $services;

    /**
     * @var array
     */
    protected $serviceClasses;

    /**
     * Private constructor
     */
    private function __construct()
    {
        $this->services = array();

        $this->serviceClasses = array(
            'service.curl' => '\\WebDriver\\Service\\CurlService',
        );
    }

    /**
     * Get singleton instance
     *
     * @return \WebDriver\ServiceFactory
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Get service
     *
     * @param string $serviceName Name of service
     *
     * @return object
     */
    public function getService($serviceName)
    {
        if (! isset($this->services[$serviceName])) {
            $className = $this->serviceClasses[$serviceName];

            $this->services[$serviceName] = new $className();
        }

        return $this->services[$serviceName];
    }

    /**
     * Set service
     *
     * @param string $serviceName Name of service
     * @param object $service     Service instance
     */
    public function setService($serviceName, $service)
    {
        $this->services[$serviceName] = $service;
    }

    /**
     * Override default service class
     *
     * @param string $serviceName Name of service
     * @param string $className   Name of service class
     */
    public function setServiceClass($serviceName, $className)
    {
        if (substr($className, 0, 1) !== '\\') {
            $className = '\\' . $className;
        }

        $this->serviceClasses[$serviceName] = $className;
        $this->services[$serviceName] = null;
    }
}
