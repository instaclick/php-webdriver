<?php
/**
 * Copyright 2004-2012 Facebook. All Rights Reserved.
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
 * @author Anthon Pang <anthonp@nationalfibre.net>
 */

namespace WebDriver;

/**
 * WebDriver class
 *
 * @package WebDriver
 *
 * @method status
 */
final class WebDriver extends AbstractWebDriver
{
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
     * New Session: /session (POST)
     * Get session object for chaining
     *
     * @param string $browser                Browser name
     * @param array  $additionalCapabilities Additional capabilities desired
     *
     * @return \WebDriver\Session
     */
    public function session($browser = Browser::FIREFOX, $additionalCapabilities = array())
    {
        $desiredCapabilities = array_merge(
            $additionalCapabilities,
            array(Capability::BROWSER_NAME => $browser)
        );

        $results = $this->curl(
            'POST',
            '/session',
            array('desiredCapabilities' => $desiredCapabilities),
            array(CURLOPT_FOLLOWLOCATION => true)
        );

        return new Session($results['info']['url']);
    }

    /**
     * Get list of currently active sessions
     *
     * @return array an array of \WebDriver\Session objects
     */
    public function sessions()
    {
        $result   = $this->curl('GET', '/sessions');
        $sessions = array();

        foreach ($result['value'] as $session) {
            $sessions[] = new Session($this->url . '/session/' . $session['id']);
        }

        return $sessions;
    }
}
