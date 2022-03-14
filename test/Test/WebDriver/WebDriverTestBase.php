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
use WebDriver\Service\CurlService;
use WebDriver\ServiceFactory;
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

    private $testDocumentRootUrl = 'http://localhost';

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
}
