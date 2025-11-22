<?php

/**
 * @copyright 2004 Meta Platforms, Inc.
 * @license Apache-2.0
 *
 * @author Justin Bishop <jubishop@gmail.com>
 */

namespace WebDriver\Service;

use WebDriver\Exception\CurlExec as CurlExecException;

/**
 * WebDriver\Service\CurlService class
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
    public function __construct($defaultOptions = [])
    {
        $this->defaultOptions = is_array($defaultOptions) ? $defaultOptions : [];
    }

    /**
     * {@inheritdoc}
     */
    public function execute($requestMethod, $url, $parameters = null, $extraOptions = [])
    {
        $customHeaders = [
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json',
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        switch ($requestMethod) {
            case 'GET':
                break;

            case 'POST':
            case 'PUT':
                $parameters = is_array($parameters) ? json_encode($parameters) : '{}';

                curl_setopt($curl, CURLOPT_POSTFIELDS, $parameters);

                // Suppress "Expect: 100-continue" header automatically added by cURL that
                // causes a 1 second delay if the remote server does not support Expect.
                $customHeaders[] = 'Expect:';

                $requestMethod === 'POST'
                    ? curl_setopt($curl, CURLOPT_POST, true)
                    : curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                break;

            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $customHeaders);

        foreach (array_replace($this->defaultOptions, $extraOptions) as $option => $value) {
            curl_setopt($curl, $option, $value);
        }

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
            if (\PHP_VERSION_ID < 80000) {
                curl_close($curl);
            }

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
        if (\PHP_VERSION_ID < 80000) {
            curl_close($curl);
        }

        return [$rawResult, $info];
    }
}
