<?php

/**
 * @copyright 2023 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace Test\WebDriver;

use PHPUnit\Framework\TestCase;
use WebDriver\Session;

/**
 * Test WebDriver\Session class
 *
 * @package WebDriver
 *
 * @group Unit
 */
class SessionTest extends TestCase
{
    /**
     * test getNewIdentifierPath
     */
    public function testGetNewIdentifierPath()
    {
        $session = new Session('http://example.com/session/session-1234567890', []);

        $method = $this->makeCallable($session, 'getNewIdentifierPath');

        $this->assertEquals('http://example.com/session/session-1234567890/element/element-9876543210', $method->invoke($session, 'element-9876543210'));
    }

    /**
     * Make private and protected function callable
     *
     * @param mixed  $object   Subject under test
     * @param string $function Function name
     *
     * @return \ReflectionMethod
     */
    private function makeCallable($object, $function)
    {
        $method = new \ReflectionMethod($object, $function);
        $method->setAccessible(true);

        return $method;
    }
}
