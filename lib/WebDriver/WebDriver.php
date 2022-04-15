<?php

/**
 * Copyright 2004-2022 Facebook. All Rights Reserved.
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
 */

namespace WebDriver;

/**
 * WebDriver class
 *
 * @package WebDriver
 *
 * @method array status() Returns information about whether a remote end is in a state in which it can create new sessions.
 */
class WebDriver extends AbstractWebDriver implements WebDriverInterface
{
    /**
     * @var array
     */
    private $capabilities;

    /**
     * @var boolean
     */
    private $legacy;

    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return array(
            'status' => 'GET',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function session($browserName = Browser::FIREFOX, $desiredCapabilities = null, $requiredCapabilities = null)
    {
        // default to W3C WebDriver API
        $firstMatch = $desiredCapabilities ?: array();
        $firstMatch[] = array('browserName' => Browser::CHROME);

        if ($browserName !== Browser::CHROME) {
            $firstMatch[] = array('browserName' => $browserName);
        }

        $parameters = array('capabilities' => array('firstMatch' => $firstMatch));

        if (is_array($requiredCapabilities) && count($requiredCapabilities)) {
            $parameters['capabilities']['alwaysMatch'] = $requiredCapabilities;
        }

        try {
            $result = $this->curl(
                'POST',
                '/session',
                $parameters,
                array(CURLOPT_FOLLOWLOCATION => true)
            );
        } catch (\Exception $e) {
            // fallback to legacy JSON Wire Protocol
            $capabilities = $desiredCapabilities ?: array();
            $capabilities[Capability::BROWSER_NAME] = $browserName;

            $parameters = array('desiredCapabilities' => $capabilities);

            if (is_array($requiredCapabilities) && count($requiredCapabilities)) {
                $parameters['requiredCapabilities'] = $requiredCapabilities;
            }

            $result = $this->curl(
                'POST',
                '/session',
                $parameters,
                array(CURLOPT_FOLLOWLOCATION => true)
            );
        }

        $this->capabilities = isset($result['value']['capabilities']) ? $result['value']['capabilities'] : null;
        $this->legacy       = ! $this->capabilities; // initially

        $session = new Session($result['sessionUrl']);
        $session->setCapabilities($this->capabilities);
        $session->setLegacy($this->legacy);

        return $session;
    }

    /**
     * Get Sessions: /sessions (GET)
     * Get list of currently active sessions
     *
     * @deprecated
     *
     * @return array an array of \WebDriver\Session objects
     */
    public function sessions()
    {
        $result = $this->curl('GET', '/sessions');
        $sessions = array();

        foreach ($result['value'] as $session) {
            $session = new Session($this->url . '/session/' . $session['id']);
            $session->setCapabilities($this->capabilities);
            $session->setLegacy($this->legacy);

            $sessions[] = $session;
        }

        return $sessions;
    }
}
