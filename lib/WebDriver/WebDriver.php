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
 * WebDriver client class
 *
 * @package WebDriver
 *
 * W3C
 * @method void session($parameters) New session.
 * @method array status() Returns information about whether a remote end is in a state in which it can create new sessions.
 * Selenium
 * @method array logs() Returns session logs mapped to session IDs.
 * @method array sessions() Get all sessions.
 */
class WebDriver extends AbstractWebDriver
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
        return [
            'session'  => ['POST'],
            'status'   => ['GET'],

            // @deprecated
            'logs'     => ['POST'],
            'sessions' => ['GET'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return [
            'session'  => 'newSession',
            'status'   => 'getStatus',

            // @deprecated
            'logs'     => 'getSessionLogs',
            'sessions' => 'getAllSessions',
        ];
    }

    /**
     * New Session: /session (POST)
     * Returns a session object suitable for chaining
     *
     * @param array|string $browserName          Preferred browser
     * @param array        $desiredCapabilities  Optional desired capabilities
     * @param array        $requiredCapabilities Optional required capabilities
     *
     * @return \WebDriver\Session
     */
    public function newSession($browserName = Browser::CHROME, $desiredCapabilities = null, $requiredCapabilities = null)
    {
        if (func_num_args() === 1 && is_array($browserName)) {
            $parameters = $browserName;
        } else {
            $firstMatch = $desiredCapabilities ?: [];
            $firstMatch[] = ['browserName' => $browserName];

            $parameters = ['capabilities' => ['firstMatch' => $firstMatch]];

            if (is_array($requiredCapabilities) && count($requiredCapabilities)) {
                $parameters['capabilities']['alwaysMatch'] = $requiredCapabilities;
            }
        }

        $options = [CURLOPT_FOLLOWLOCATION => true];
        $result = $this->curl('POST', 'session', $parameters, $options);

        $this->capabilities = $result['value']['capabilities'] ?? $result['value']['capabilities'];

        $session = new Session($result['sessionUrl'], $this->capabilities);

        return $session;
    }

    /**
     * Get all sessions: /sessions (GET)
     * Get list of currently active sessions
     *
     * @see https://github.com/SeleniumHQ/selenium/blob/trunk/java/src/org/openqa/selenium/remote/codec/AbstractHttpCommandCodec.java
     * @deprecated
     *
     * @return array an array of \WebDriver\Session objects
     */
    public function getAllSessions()
    {
        $result = $this->curl('GET', 'sessions');
        $sessions = [];

        foreach ($result['value'] as $session) {
            $session = new Session($this->url . '/session/' . $session['id'], $this->capabilities);

            $sessions[] = $session;
        }

        return $sessions;
    }

    /**
     * Get session logs: /logs
     *
     * @deprecated
     *
     * @return mixed
     */
    public function getSessionLogs()
    {
        $result = $this->curl('POST', 'logs');

        return $result['value'];
    }

    /**
     * Get status: /status
     *
     * @return mixed
     */
    public function getStatus()
    {
        $result = $this->curl('GET', 'status');

        return $result['value'];
    }
}
