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
 * @method void async_script($json) Set the amount of time, in milliseconds, that asynchronous scripts (executed by execute_async) are permitted to run before they are aborted and a timeout error is returned to the client.
 * @method void implicit_wait($json) Set the amount of time the driver should wait when searching for elements.
 */
class Timeouts extends AbstractWebDriver
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return array(
            // Legacy JSON Wire Protocol
            'async_script' => array('POST'),
            'implicit_wait' => array('POST'),
        );
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
    public function wait($callback, $maxIterations = 1, $sleep = 0, $args = array())
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
