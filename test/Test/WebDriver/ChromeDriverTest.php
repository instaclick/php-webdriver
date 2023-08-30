<?php

/**
 * Copyright 2021-2022 Anthon Pang. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace Test\WebDriver;

use Test\WebDriver\WebDriverTestBase;
use WebDriver\Browser;
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

    protected function setUp(): void
    {
        parent::setUp();
        try {
            $this->status = $this->driver->status();
            $this->session = $this->driver->session(Browser::CHROME, [
                'goog:chromeOptions' => [
                    'w3c' => true,
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

    /**
     * Test driver status
     */
    public function testStatus()
    {
        $this->assertEquals(1, $this->status['ready'], 'Chromedriver is not ready');
        $this->assertEquals('ChromeDriver ready for new sessions.', $this->status['message'], 'Chromedriver is not ready');
        $this->assertNotEmpty($this->status['os'], 'OS info not detected');
    }
}
