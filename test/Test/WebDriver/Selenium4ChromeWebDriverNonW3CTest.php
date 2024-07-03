<?php

namespace Test\WebDriver;

use WebDriver\Browser;

/**
 * Selenium WebDriver
 *
 * @package WebDriver
 *
 * @group Functional
 */
class Selenium4ChromeWebDriverNonW3CTest extends SeleniumWebDriverTestBase
{
    protected $testWebDriverRootUrl = 'http://chrome:4444';
    protected $w3c = FALSE;

    /**
     * Run before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        try {
            $this->status = $this->driver->status();
            $this->session = $this->driver->session(Browser::CHROME, [
                'goog:chromeOptions' => [
                    'w3c' => false,
                    'args' => [
                        '--no-sandbox',
                        '--ignore-certificate-errors',
                        '--allow-insecure-localhost',
                        '--headless',
                    ],
                ],
            ]);
        }
        catch (\Exception $e) {
            if ($this->isWebDriverDown($e)) {
                $this->fail("{$this->testWebDriverName} server not running: {$e->getMessage()}");
            }
            throw $e;
        }
    }
}
