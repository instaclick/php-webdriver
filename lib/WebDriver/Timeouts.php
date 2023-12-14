<?php

/**
 * @copyright 2011 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

use WebDriver\Exception as WebDriverException;

/**
 * WebDriver\Timeouts class
 *
 * @package WebDriver
 *
 * Selenium
 * @method void async_script($parameters) Set the amount of time, in milliseconds, that asynchronous scripts (executed by execute_async) are permitted to run before they are aborted and a timeout error is returned to the client.
 * @method void implicit_wait($parameters) Set the amount of time the driver should wait when searching for elements.
 */
class Timeouts extends AbstractWebDriver
{
    // Timeout name constants
    const IMPLICIT  = 'implicit';
    const PAGE_LOAD = 'pageLoad';
    const SCRPT     = 'script';

    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return [
            // @deprecated
            'async_script'  => ['POST'],
            'implicit_wait' => ['POST'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return [
            // @deprecated
            'async_script'  => 'setScriptTimeout',
            'implicit_wait' => 'implicitlyWait',
        ];
    }

    /**
     * Get timeouts: /session/:sessionId/timeouts (GET)
     *
     * @return mixed
     */
    public function getTimeouts()
    {
        $result = $this->curl('GET', '');

        return $result['value'];
    }

    /**
     * Implicitly wait: /session/:sessionId/timeout/implicit_wait (POST)
     *
     * @deprecated
     *
     * @param array|integer $ms Parameters {ms: ...}
     *
     * @return \WebDriver\Timeouts
     */
    public function implicitlyWait($ms)
    {
        $parameters = is_array($ms)
            ? $ms
            : ['ms' => $ms];

        // trigger_error(__METHOD__ . ': use "setTimeout()" instead', E_USER_DEPRECATED);

        $result = $this->curl('POST', '/implicit_wait', $parameters);

        return $this;
    }

    /**
     * Set script timeout: /session/:sessionId/timeout/async_script (POST)
     *
     * @deprecated
     *
     * @param array|integer $ms Parameters {ms: ...}
     *
     * @return \WebDriver\Timeouts
     */
    public function setScriptTimeout($ms)
    {
        $parameters = is_array($ms)
            ? $ms
            : ['ms' => $ms];

        // trigger_error(__METHOD__ . ': use "setTimeout()" instead', E_USER_DEPRECATED);

        $result = $this->curl('POST', '/async_script', $parameters);

        return $this;
    }

    /**
     * Set timeout: /session/:sessionId/timeouts (POST)
     *
     * @param string|array $type    Timeout name (see constants above)
     * @param integer      $timeout Duration in milliseconds
     *
     * @return \WebDriver\Timeouts
     */
    public function setTimeout($type, $timeout = null)
    {
        // set timeouts
        $parameters = func_num_args() === 1 && is_array($type)
            ? $type
            : [$type => $timeout];

        $this->curl('POST', '', $parameters);

        return $this;
    }

    /**
     * helper method to wait until user-defined condition is met
     *
     * @param callable $callback      callback which returns non-false result if wait condition was met
     * @param integer  $maxIterations maximum number of iterations
     * @param integer  $sleep         sleep duration in seconds between iterations
     * @param array    $args          optional args; if the callback needs $this, then pass it here
     *
     * @return mixed result from callback function
     *
     * @throws \Exception if thrown by callback, or \WebDriver\Exception\Timeout if helper times out
     */
    public function wait($callback, $maxIterations = 1, $sleep = 0, $args = [])
    {
        $i = max(1, $maxIterations);

        while ($i-- > 0) {
            $result = call_user_func_array($callback, $args);

            if ($result !== false) {
                return $result;
            }

            // don't sleep on the last iteration
            $i && sleep($sleep);
        }

        throw WebDriverException::factory(WebDriverException::TIMEOUT, 'wait() method timed out');
    }
}
