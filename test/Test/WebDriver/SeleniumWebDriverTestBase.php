<?php

namespace Test\WebDriver;

/**
 * Selenium WebDriver
 *
 * @package WebDriver
 *
 * @group Functional
 */
abstract class SeleniumWebDriverTestBase extends WebDriverTestBase
{
    protected $testWebDriverRootUrl = '';
    protected $testWebDriverName = 'selenium';
    protected $status = null;
    protected $w3c = true;

   /**
    * Test driver status
    */
    public function testStatus()
    {
        $this->assertEquals(1, $this->status['ready'], 'Selenium is not ready');
        $this->assertEquals('Selenium Grid ready.', $this->status['message'], 'Selenium is not ready');
        $this->assertNotEmpty($this->status['nodes'][0]['osInfo'], 'OS info not detected');
        $this->assertSame($this->w3c, $this->driver->isW3c());
    }
}
