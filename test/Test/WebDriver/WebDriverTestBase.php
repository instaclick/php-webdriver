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
