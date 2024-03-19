<?php

/**
 * @copyright 2004 Meta Platforms, Inc.
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Justin Bishop <jubishop@gmail.com>
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
        $firstMatch = $desiredCapabilities ? array($desiredCapabilities) : array();
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

        $session = new Session($result['sessionUrl'], $this->capabilities);

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
            $session = new Session($this->url . '/session/' . $session['id'], $this->capabilities);

            $sessions[] = $session;
        }

        return $sessions;
    }
}
