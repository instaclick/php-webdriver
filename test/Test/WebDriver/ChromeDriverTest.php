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

use Test\WebDriver\WebDriverTestBase;
use WebDriver\Session;

/**
 * ChromeDriver
 *
 * @package WebDriver
 *
 * @group Functional
 */
class ChromeDriverTest extends WebDriverTestBase
{
    protected $testWebDriverRootUrl = 'http://localhost:9515';
    protected $testWebDriverName    = 'chromedriver';

    /**
     * Test driver session
     */
    public function testSession()
    {
        try {
            $this->session = $this->driver->session();
        } catch (\Exception $e) {
            if ($this->isWebDriverDown($e)) {
                $this->markTestSkipped("{$this->testWebDriverName} server not running");

                return;
            }

            throw $e;
        }

        $this->assertTrue($this->session instanceof Session);
    }

    /**
    /**
     * Test driver status
     */
    public function testStatus()
    {
        try {
            $status = $this->driver->status();
        } catch (\Exception $e) {
            if ($this->isWebDriverDown($e)) {
                $this->markTestSkipped("{$this->testWebDriverName} server not running");

                return;
            }

            throw $e;
        }

        $this->assertCount(4, $status);
        $this->assertTrue(isset($status['build']));
        $this->assertTrue(isset($status['message']));
        $this->assertTrue(isset($status['os']));
        $this->assertTrue(isset($status['ready']));
    }
}
