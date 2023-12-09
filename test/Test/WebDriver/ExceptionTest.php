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
use WebDriver\Exception;

/**
 * Test WebDriver\Exception class
 *
 * @package WebDriver
 *
 * @group Unit
 */
class ExceptionTest extends TestCase
{
    /**
     * test factory()
     */
    public function testFactory()
    {
        $out = Exception::factory(255, 'wtf');
        $this->assertTrue($out instanceof Exception\UnknownError);
        $this->assertTrue($out->getMessage() === 'wtf');

        $out = Exception::factory(0);
        $this->assertTrue($out instanceof Exception\UnknownError);
        $this->assertTrue($out->getMessage() === 'An unknown error occurred in the remote end while processing the command.');

        $out = Exception::factory(Exception::SESSION_NOT_CREATED);
        $this->assertTrue($out instanceof Exception\SessionNotCreated);
        $this->assertTrue(strpos($out->getMessage(), 'A new session could not be created') !== false);

        $out = Exception::factory(Exception::_CURL_EXEC);
        $this->assertTrue($out instanceof Exception\CurlExec);
        $this->assertTrue($out->getMessage() === 'curl_exec() error.');
    }
}
