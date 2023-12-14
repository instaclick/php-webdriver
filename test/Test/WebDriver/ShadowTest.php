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
use WebDriver\Shadow;

/**
 * Test WebDriver\Shadow class
 *
 * @package WebDriver
 *
 * @group Unit
 */
class ShadowTest extends TestCase
{
    /**
     * test getID
     */
    public function testGetID()
    {
        $shadow = new Shadow('http://example.com/session/:sessionId/shadow', 'shadow-1234567890');

        $this->assertEquals('shadow-1234567890', $shadow->getID());
    }

    /**
     * test getNewIdentifierPath
     */
    public function testGetNewIdentifierPath()
    {
        $shadow = new Shadow('http://example.com/session/:sessionId/shadow', 'shadow-1234567890');

        $method = $this->makeCallable($shadow, 'getNewIdentifierPath');

        $this->assertEquals('http://example.com/session/:sessionId/element/element-9876543210', $method->invoke($shadow, 'element-9876543210'));
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
