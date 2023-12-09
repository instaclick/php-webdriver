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
use WebDriver\Element;

/**
 * Test WebDriver\Element class
 *
 * @package WebDriver
 *
 * @group Unit
 */
class ElementTest extends TestCase
{
    /**
     * test getID
     */
    public function testGetID()
    {
        $element = new Element('http://example.com/session/:sessionId/element', 'element-1234567890');

        $this->assertEquals('element-1234567890', $element->getID());
    }

    /**
     * test getNewIdentifierPath
     */
    public function testGetNewIdentifierPath()
    {
        $element = new Element('http://example.com/session/:sessionId/element', 'element-1234567890');

        $method = $this->makeCallable($element, 'getNewIdentifierPath');

        $this->assertEquals('http://example.com/session/:sessionId/element/element-9876543210', $method->invoke($element, 'element-9876543210'));
    }

    /**
     * test getSessionPath
     */
    public function testGetSessionPath()
    {
        $element = new Element('http://example.com/session/:sessionId/element', 'element-1234567890');

        $method = $this->makeCallable($element, 'getSessionPath');

        $this->assertEquals('http://example.com/session/:sessionId', $method->invoke($element));
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
