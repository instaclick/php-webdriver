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
class Selenium4GeckoWebDriverTest extends SeleniumWebDriverTestBase
{
    protected $testWebDriverRootUrl = 'http://firefox:4444';

    /**
     * Run before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        try {
            $this->status = $this->driver->status();
            $this->session = $this->driver->session(Browser::FIREFOX, [
                'moz:firefoxOptions' => [
                    'args' => [
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
