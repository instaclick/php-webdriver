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
 * GeckoDriver
 *
 * @package WebDriver
 *
 * @group Functional
 */
class GeckoDriverTest extends WebDriverTestBase
{
    protected $testWebDriverRootUrl = 'http://localhost:4444';
    protected $testWebDriverName    = 'geckodriver';

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

        $this->assertCount(2, $status);
        $this->assertTrue(isset($status['message']));
        $this->assertTrue(isset($status['ready']));
    }
}
