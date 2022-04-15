<?php

/**
 * @copyright 2012 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver\Service;

/**
 * WebDriver\Service\CurlServiceInterface class
 *
 * @package WebDriver
 */
interface CurlServiceInterface
{
    /**
     * Send protocol request to WebDriver server using curl extension API.
     *
     * @param string $requestMethod HTTP request method, e.g., 'GET', 'POST', or 'DELETE'
     * @param string $url           Request URL
     * @param array  $parameters    If an array(), they will be posted as JSON parameters
     *                              If a number or string, "/$params" is appended to url
     * @param array  $extraOptions  key=>value pairs of curl options to pass to curl_setopt()
     *
     * @return array
     *
     * @throws \WebDriver\Exception\CurlExec only if http error and CURLOPT_FAILONERROR has been set in extraOptions
     */
    public function execute($requestMethod, $url, $parameters = null, $extraOptions = array());
}
