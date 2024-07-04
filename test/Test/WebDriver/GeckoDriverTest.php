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

use WebDriver\Browser;
use WebDriver\WebDriver;
use WebDriver\Exception\CurlExec;

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
    protected $status = null;

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

    /**
     * Test driver status
     */
    public function testStatus()
    {
        $this->assertEquals(1, $this->status['ready'], 'Chromedriver is not ready');
    }

    /**
     * Checks that an error connecting to WebDriver gives back the expected exception
     */
    public function testWebDriverError()
    {
        $this->session->close();
        $this->session = null;
        try {
            $this->driver = new WebDriver($this->getTestWebDriverRootUrl() . '/../invalidurl');
            $this->driver->status();
            $this->fail('Exception not thrown while connecting to invalid WebDriver url');
        }
        catch (\Exception $e) {
            $this->assertEquals(CurlExec::class, get_class($e), $e->getMessage());
        }
    }

}
