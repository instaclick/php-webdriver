<?php

/**
 * Copyright 2021-2021 Anthon Pang. All Rights Reserved.
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
