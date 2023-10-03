<?php

/**
 * @copyright 2004 Meta Platforms, Inc.
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Justin Bishop <jubishop@gmail.com>
 */

namespace WebDriver\Service;

use WebDriver\Exception\CurlExec as CurlExecException;

/**
 * WebDriver\Service\CurlService class
 *
 * @package WebDriver
 */
class CurlService implements CurlServiceInterface
{
    /**
     * @var array
     */
    private $defaultOptions;

    /**
     * Constructor
     *
     * @param mixed $defaultOptions
     */
    public function __construct($defaultOptions = array())
    {
        $this->defaultOptions = is_array($defaultOptions) ? $defaultOptions : array();
    }

    /**
     * {@inheritdoc}
     */
    public function execute($requestMethod, $url, $parameters = null, $extraOptions = array())
    {
        $customHeaders = array(
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json',
        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        switch ($requestMethod) {
            case 'GET':
                break;

            case 'POST':
                if ($parameters && is_array($parameters)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($parameters));
                } else {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, "{}");
                    $customHeaders[] = 'Content-Length: 2';

                    // Suppress "Transfer-Encoding: chunked" header automatically added by cURL that
                    // causes a 400 bad request (bad content-length).
                    $customHeaders[] = 'Transfer-Encoding:';
                }

                // Suppress "Expect: 100-continue" header automatically added by cURL that
                // causes a 1 second delay if the remote server does not support Expect.
                $customHeaders[] = 'Expect:';

                curl_setopt($curl, CURLOPT_POST, true);
                break;

            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;

            case 'PUT':
                if ($parameters && is_array($parameters)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($parameters));
                } else {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, "{}");
                    $customHeaders[] = 'Content-Length: 2';

                    // Suppress "Transfer-Encoding: chunked" header automatically added by cURL that
                    // causes a 400 bad request (bad content-length).
                    $customHeaders[] = 'Transfer-Encoding:';
                }

                // Suppress "Expect: 100-continue" header automatically added by cURL that
                // causes a 1 second delay if the remote server does not support Expect.
                $customHeaders[] = 'Expect:';

                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                break;
        }

        foreach (array_replace($this->defaultOptions, $extraOptions) as $option => $value) {
            curl_setopt($curl, $option, $value);
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $customHeaders);

        $rawResult = curl_exec($curl);
        $rawResult = is_string($rawResult) ? trim($rawResult) : '';

        $info = curl_getinfo($curl);
        $info['request_method'] = $requestMethod;
        $info['errno'] = curl_errno($curl);
        $info['error'] = curl_error($curl);

        if (array_key_exists(CURLOPT_FAILONERROR, $extraOptions) &&
            $extraOptions[CURLOPT_FAILONERROR] &&
            CURLE_GOT_NOTHING !== ($errno = curl_errno($curl)) &&
            $error = curl_error($curl)
        ) {
            curl_close($curl);

            $e = new CurlExecException(
                sprintf(
                    "Curl error thrown for http %s to %s%s\n\n%s",
                    $requestMethod,
                    $url,
                    $parameters && is_array($parameters) ? ' with params: ' . json_encode($parameters) : '',
                    $error
                ),
                $errno
            );

            $e->setCurlInfo($info);

            throw $e;
        }

        curl_close($curl);

        return array($rawResult, $info);
    }
}
