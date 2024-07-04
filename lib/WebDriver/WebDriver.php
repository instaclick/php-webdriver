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
    public function session($browserName = Browser::FIREFOX, $desiredCapabilities = array(), $requiredCapabilities = array())
    {
        // Filter capabilities.
        $filterCapabilites = function($key) {
          // See https://github.com/jlipps/simple-wd-spec#capabilities
          if (str_contains($key, ':')) {
            return true;
          }

          return in_array($key, [
            'browserName',
            'browserVersion',
            'platformName',
            'acceptInsecureCerts',
            'pageLoadStrategy',
            'proxy',
            'setWindowRect',
            'timeouts',
            'timeouts',
          ]);
        };

        $w3c_mode = true;
        if (
            (isset($desiredCapabilities['w3c']) && $desiredCapabilities['w3c'] === false) ||
            (isset($desiredCapabilities['goog:chromeOptions']['w3c']) && $desiredCapabilities['goog:chromeOptions']['w3c'] === false)
        ) {
          $w3c_mode = false;
        }

        if ($w3c_mode) {
          $requiredCapabilities = array_filter($requiredCapabilities, $filterCapabilites, ARRAY_FILTER_USE_KEY);
          $desiredCapabilities = array_filter($desiredCapabilities, $filterCapabilites, ARRAY_FILTER_USE_KEY);
        }

        $firstMatch = $desiredCapabilities ?: array();
        $firstMatch['browserName'] = $browserName;
        $parameters = array('capabilities' => array('firstMatch' => [$firstMatch]));
        if (is_array($requiredCapabilities) && count($requiredCapabilities)) {
            $parameters['capabilities']['alwaysMatch'] = $requiredCapabilities;
        }

        if (!$w3c_mode) {
          // fallback to legacy JSON Wire Protocol
          $capabilities = $desiredCapabilities ?: array();
          $capabilities[Capability::BROWSER_NAME] = $browserName;

          $parameters = array('desiredCapabilities' => $capabilities);

          if (is_array($requiredCapabilities) && count($requiredCapabilities)) {
            $parameters['requiredCapabilities'] = $requiredCapabilities;
          }
        }

        $result = $this->curl(
            'POST',
            '/session',
            $parameters,
            array(CURLOPT_FOLLOWLOCATION => true)
        );

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
