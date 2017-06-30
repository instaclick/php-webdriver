<?php

namespace Test\WebDriver;

use WebDriver\Service\CurlServiceInterface;

/**
 * HTTP 200 response for any request:
 * - /session returns invalid json
 * - any other request returns empty body
 */
class TestCurlService implements CurlServiceInterface
{
    public function execute($requestMethod, $url, $parameters = null, $extraOptions = array())
    {
        $info = array(
            'url' => $url,
            'request_method' => $requestMethod,
            'http_code' => 200,
        );
        if (preg_match('#.*session$#', $url)) {
            $result = 'some invalid json';
        } else {
            $result = '';
        }
        return array($result, $info);
    }
}
