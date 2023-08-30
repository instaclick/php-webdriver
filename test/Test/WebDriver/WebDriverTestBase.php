<?php

/**
 * Copyright 2014-2022 Anthon Pang. All Rights Reserved.
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
 * @author Damian Mooyman <damian@silverstripe.com>
 */

namespace Test\WebDriver;

use PHPUnit\Framework\TestCase;
use WebDriver\Exception\CurlExec;
use WebDriver\Exception\NoSuchElement;
use WebDriver\Exception\UnknownCommand;
use WebDriver\Service\CurlService;
use WebDriver\ServiceFactory;
use WebDriver\Session;
use WebDriver\WebDriver;

/**
 * Test WebDriver\WebDriver class
 *
 * @package WebDriver
 *
 * @group Functional
 */
abstract class WebDriverTestBase extends TestCase
{
    protected $driver;
    protected $session;
    protected $testWebDriverRootUrl;
    protected $testWebDriverName;

    private $testDocumentRootUrl = 'http://web';

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        ServiceFactory::getInstance()->setServiceClass('service.curl', CurlService::class);

        $this->driver  = new WebDriver($this->getTestWebDriverRootUrl());
        $this->session = null;
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        if ($this->session) {
            $this->session->close();
        }
    }

    /**
     * Returns the full url to the test site (corresponding to the root dir of the library).
     * You can set this via env var ROOT_URL
     *
     * @return string
     */
    protected function getTestDocumentRootUrl()
    {
        return $this->testDocumentRootUrl;
    }

    /**
     * Returns the full url to the WebDriver server used for functional tests
     *
     * @return string
     *
     * @todo make this configurable via env var
     */
    protected function getTestWebDriverRootUrl()
    {
        return $this->testWebDriverRootUrl;
    }

    /**
     * Is WebDriver down?
     *
     * @param \Exception $exception
     *
     * @return boolean
     */
    protected function isWebDriverDown($exception)
    {
        return preg_match('/Failed to connect to .* Connection refused/', $exception->getMessage())
            | strpos($exception->getMessage(), 'couldn\'t connect to host') !== false
            || strpos($exception->getMessage(), 'Unable to connect to host') !== false;
    }

    /**
     * Test driver session
     */
    public function testSession()
    {
        $this->assertEquals($this->getTestWebDriverRootUrl(), $this->driver->getUrl());
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
            $this->assertEquals(UnknownCommand::class, get_class($e), $e->getMessage());
        }
    }

    /**
     * Checks that a successful command to WebDriver which returns an http error response gives back the expected exception
     */
    public function testWebDriverErrorResponse()
    {
        try {
            $this->session->open($this->getTestDocumentRootUrl() . '/test/Assets/index.html');
            $this->session->element('css selector', '#a-quite-unlikely-html-element-id');
            $this->fail('Exception not thrown while looking for missing element in page');
        }
        catch (\Exception $e) {
            $this->assertEquals(NoSuchElement::class, get_class($e), $e->getMessage());
        }
    }

    /**
     * Checks that a successful command to WebDriver which returns 'nothing' according to spec does not raise an error
     */
    public function testWebDriverNoResponse()
    {
        $session = $this->session->timeouts('script', 3000);
        $this->assertEquals(Session::class, get_class($session));
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
        $this->expectException(CurlExec::class);
        $this->expectExceptionMessage('Payload received from webdriver is not valid json: some invalid json');

        $result = $this->driver->session();

        $this->assertNull($result);
    }
}
