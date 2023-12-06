<?php
/**
 * Copyright 2004-2017 Facebook. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package WebDriver
 *
 * @author Justin Bishop <jubishop@gmail.com>
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 * @author Fabrizio Branca <mail@fabrizio-branca.de>
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
            case 'PUT':
                $parameters =  ! $parameters || ! is_array($parameters)
                    ? '{}'
                    : json_encode($parameters);

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

        foreach ($extraOptions as $option => $value) {
            curl_setopt($curl, $option, $value);
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $customHeaders);

        $rawResult = trim(curl_exec($curl));

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
