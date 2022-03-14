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
use WebDriver\Exception\CurlExec;
use WebDriver\Exception\NoSuchElement;
use WebDriver\Service\CurlService;
use WebDriver\ServiceFactory;
use WebDriver\WebDriver;

/**
 * Selenium WebDriver
 *
 * @package WebDriver
 *
 * @group Functional
 */
class SeleniumWebDriverTest extends WebDriverTestBase
{
    protected $testWebDriverRootUrl = 'http://localhost:4444/wd/hub';
    protected $testWebDriverName    = 'selenium';

    /**
     * Test driver sessions
     */
    public function testSessions()
    {
        try {
            $sessions = $this->driver->sessions();
            $this->assertCount(0, $sessions);

            $this->session = $this->driver->session();
        } catch (\Exception $e) {
            if ($this->isWebDriverDown($e)) {
                $this->markTestSkipped("{$this->testWebDriverName} server not running");

                return;
            }

            throw $e;
        }

        $this->assertCount(1, $this->driver->sessions());
        $this->assertEquals($this->getTestWebDriverRootUrl(), $this->driver->getUrl());
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

        $this->session = $this->driver->session();

        $this->assertCount(3, $status);
        $this->assertTrue(isset($status['os']));
        $this->assertTrue(isset($status['build']));
    }

    /**
     * Checks that an error connecting to WebDriver gives back the expected exception
     */
    public function testWebDriverError()
    {
        try {
            $this->driver = new WebDriver($this->getTestWebDriverRootUrl() . '/../invalidurl');

            $status = $this->driver->status();

            $this->fail('Exception not thrown while connecting to invalid WebDriver url');
        } catch (\Exception $e) {
            if ($this->isWebDriverDown($e)) {
                $this->markTestSkipped("{$this->testWebDriverName} server not running");

                return;
            }

            $this->assertEquals(CurlExec::class, get_class($e));
        }
    }

    /**
     * Checks that a successful command to WebDriver which returns an http error response gives back the expected exception
     */
    public function testWebDriverErrorResponse()
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

        try {
            $this->session = $this->driver->session();
            $this->session->open($this->getTestDocumentRootUrl() . '/test/Assets/index.html');

            $element = $this->session->element('id', 'a-quite-unlikely-html-element-id');

            $this->fail('Exception not thrown while looking for missing element in page');
        } catch (\Exception $e) {
            $this->assertEquals(NoSuchElement::class, get_class($e));
        }
    }

    /**
     * Checks that a successful command to WebDriver which returns 'nothing' according to spec does not raise an error
     */
    public function testWebDriverNoResponse()
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

        $this->session = $this->driver->session();
        $timeouts = $this->session->timeouts();
        $out = $timeouts->async_script(array('type' => 'implicit', 'ms' => 1000));

        $this->assertEquals(null, $out);
    }

    /**
     * Assert that empty response does not trigger exception, but invalid JSON does
     */
    public function testNonJsonResponse()
    {
        $mockCurlService = $this->createMock(CurlService::class);
        $mockCurlService->expects($this->any())
            ->method('execute')
            ->will($this->returnCallback(function ($requestMethod, $url) {
                $info = array(
                    'url' => $url,
                    'request_method' => $requestMethod,
                    'http_code' => 200,
                );

                $result = preg_match('#.*session$#', $url)
                    ? $result = 'some invalid json'
                    : $result = '';

                return array($result, $info);
            }));

        ServiceFactory::getInstance()->setService('service.curl', $mockCurlService);

        $this->driver  = new WebDriver($this->getTestWebDriverRootUrl());
        $result = $this->driver->status();

        $this->assertNull($result);

        // Test /session should error
        $this->expectException(\WebDriver\Exception\CurlExec::class);
        $this->expectExceptionMessage('Payload received from webdriver is not valid json: some invalid json');

        $result = $this->driver->session();

        $this->assertNull($result);
    }
}
