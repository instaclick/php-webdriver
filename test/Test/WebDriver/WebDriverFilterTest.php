<?php

/**
 * Copyright 2026 Daif Abderrahman. All Rights Reserved.
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
 * @author Daif Abderrahman <daif.abderrahman@gmail.com>
 */

namespace Test\WebDriver;

use PHPUnit\Framework\TestCase;
use WebDriver\Browser;
use WebDriver\Capability;
use WebDriver\Service\CurlService;
use WebDriver\ServiceFactory;
use WebDriver\WebDriver;

/**
 * Test WebDriver capability filtering in session creation
 *
 * @package WebDriver
 *
 * @group Unit
 */
class WebDriverFilterTest extends TestCase
{
    /**
     * @var array|null
     */
    private $capturedParameters;

    /**
     * Create a WebDriver instance with mocked CurlService that captures request parameters
     *
     * @return WebDriver
     */
    private function createDriverWithMock()
    {
        $mockCurlService = $this->createMock(CurlService::class);
        $mockCurlService->expects($this->any())
            ->method('execute')
            ->will($this->returnCallback(function ($requestMethod, $url, $parameters) {
                $this->capturedParameters = $parameters;

                $info = [
                    'url' => $url,
                    'request_method' => $requestMethod,
                    'http_code' => 200,
                ];

                $result = json_encode([
                    'value' => [
                        'sessionId' => 'mock-session-id',
                        'capabilities' => [
                            'browserName' => 'chrome',
                        ],
                    ],
                ]);

                return [$result, $info];
            }));

        ServiceFactory::getInstance()->setService('service.curl', $mockCurlService);

        return new WebDriver('http://localhost:4444/wd/hub');
    }

    /**
     * Non-W3C capabilities should be stripped from desiredCapabilities
     */
    public function testSessionFiltersNonW3cCapabilities()
    {
        $driver = $this->createDriverWithMock();

        $driver->session(Browser::CHROME, [
            Capability::BROWSER_NAME => 'chrome',
            'unknownCapability' => 'value',
            'anotherInvalidCap' => true,
        ]);

        $firstMatch = $this->capturedParameters['capabilities']['firstMatch'];
        $filtered = $firstMatch[0];

        $this->assertArrayHasKey(Capability::BROWSER_NAME, $filtered);
        $this->assertArrayNotHasKey('unknownCapability', $filtered);
        $this->assertArrayNotHasKey('anotherInvalidCap', $filtered);
    }

    /**
     * All W3C standard capabilities should pass through the filter
     */
    public function testSessionPreservesW3cCapabilities()
    {
        $driver = $this->createDriverWithMock();

        $capabilities = [
            Capability::BROWSER_NAME => 'firefox',
            Capability::BROWSER_VERSION => '120.0',
            Capability::PLATFORM_NAME => 'linux',
            Capability::ACCEPT_INSECURE_CERTS => true,
            Capability::PAGE_LOAD_STRATEGY => 'normal',
            Capability::SET_WINDOW_RECT => true,
            Capability::STRICT_FILE_INTERACTABILITY => false,
            Capability::TIMEOUTS => ['implicit' => 5000],
            Capability::UNHANDLED_PROMPT_BEHAVIOR => 'dismiss',
        ];

        $driver->session(Browser::FIREFOX, $capabilities);

        $firstMatch = $this->capturedParameters['capabilities']['firstMatch'];
        $filtered = $firstMatch[0];

        foreach ($capabilities as $key => $value) {
            $this->assertArrayHasKey($key, $filtered, "W3C capability '$key' should be preserved");
            $this->assertSame($value, $filtered[$key], "W3C capability '$key' value should be unchanged");
        }
    }

    /**
     * Vendor extension capabilities (containing ':') should pass through the filter
     */
    public function testSessionPreservesExtensionCapabilities()
    {
        $driver = $this->createDriverWithMock();

        $chromeOptions = ['args' => ['--headless', '--no-sandbox']];
        $firefoxOptions = ['prefs' => ['dom.webnotifications.enabled' => false]];

        $driver->session(Browser::CHROME, [
            Capability::BROWSER_NAME => 'chrome',
            'goog:chromeOptions' => $chromeOptions,
            'moz:firefoxOptions' => $firefoxOptions,
            'ms:edgeOptions' => ['args' => ['--start-maximized']],
        ]);

        $firstMatch = $this->capturedParameters['capabilities']['firstMatch'];
        $filtered = $firstMatch[0];

        $this->assertArrayHasKey('goog:chromeOptions', $filtered);
        $this->assertSame($chromeOptions, $filtered['goog:chromeOptions']);
        $this->assertArrayHasKey('moz:firefoxOptions', $filtered);
        $this->assertSame($firefoxOptions, $filtered['moz:firefoxOptions']);
        $this->assertArrayHasKey('ms:edgeOptions', $filtered);
    }

    /**
     * Capabilities with falsy values (false, empty string, empty array) must NOT be stripped.
     *
     * This is critical: a user may explicitly set acceptInsecureCerts => false to disable
     * a capability that is enabled by default. The filter must preserve user intent.
     */
    public function testSessionPreservesFalsyCapabilityValues()
    {
        $driver = $this->createDriverWithMock();

        $driver->session(Browser::CHROME, [
            Capability::ACCEPT_INSECURE_CERTS => false,
            Capability::SET_WINDOW_RECT => false,
            Capability::STRICT_FILE_INTERACTABILITY => false,
        ]);

        $firstMatch = $this->capturedParameters['capabilities']['firstMatch'];
        $filtered = $firstMatch[0];

        $this->assertArrayHasKey(Capability::ACCEPT_INSECURE_CERTS, $filtered, 'acceptInsecureCerts => false must not be stripped');
        $this->assertFalse($filtered[Capability::ACCEPT_INSECURE_CERTS]);

        $this->assertArrayHasKey(Capability::SET_WINDOW_RECT, $filtered, 'setWindowRect => false must not be stripped');
        $this->assertFalse($filtered[Capability::SET_WINDOW_RECT]);

        $this->assertArrayHasKey(Capability::STRICT_FILE_INTERACTABILITY, $filtered, 'strictFileInteractability => false must not be stripped');
        $this->assertFalse($filtered[Capability::STRICT_FILE_INTERACTABILITY]);
    }

    /**
     * Null desiredCapabilities should not cause errors
     */
    public function testSessionWithNullCapabilities()
    {
        $driver = $this->createDriverWithMock();

        $session = $driver->session(Browser::CHROME, null);

        $firstMatch = $this->capturedParameters['capabilities']['firstMatch'];

        // Without capabilities, firstMatch should only contain the default chrome entry
        $this->assertCount(1, $firstMatch);
        $this->assertEquals([Capability::BROWSER_NAME => Browser::CHROME], $firstMatch[0]);
    }

    /**
     * requiredCapabilities (alwaysMatch) should also be filtered
     */
    public function testSessionFiltersRequiredCapabilities()
    {
        $driver = $this->createDriverWithMock();

        $driver->session(Browser::CHROME, null, [
            Capability::PLATFORM_NAME => 'linux',
            'unknownCap' => 'value',
            'goog:chromeOptions' => ['args' => ['--headless']],
        ]);

        $alwaysMatch = $this->capturedParameters['capabilities']['alwaysMatch'];

        $this->assertArrayHasKey(Capability::PLATFORM_NAME, $alwaysMatch);
        $this->assertArrayNotHasKey('unknownCap', $alwaysMatch);
        $this->assertArrayHasKey('goog:chromeOptions', $alwaysMatch);
    }

    /**
     * Legacy JSON Wire Protocol capability names should be remapped to W3C names
     */
    public function testSessionRemapsLegacyCapabilities()
    {
        $driver = $this->createDriverWithMock();

        $driver->session(Browser::CHROME, [
            Capability::PLATFORM => 'LINUX',
            Capability::VERSION => '120.0',
            Capability::ACCEPT_SSL_CERTS => true,
        ]);

        $firstMatch = $this->capturedParameters['capabilities']['firstMatch'];
        $filtered = $firstMatch[0];

        // Legacy keys should be remapped to W3C equivalents
        $this->assertArrayHasKey(Capability::PLATFORM_NAME, $filtered);
        $this->assertEquals('LINUX', $filtered[Capability::PLATFORM_NAME]);

        $this->assertArrayHasKey(Capability::BROWSER_VERSION, $filtered);
        $this->assertEquals('120.0', $filtered[Capability::BROWSER_VERSION]);

        $this->assertArrayHasKey(Capability::ACCEPT_INSECURE_CERTS, $filtered);
        $this->assertTrue($filtered[Capability::ACCEPT_INSECURE_CERTS]);

        // Original legacy keys should not remain
        $this->assertArrayNotHasKey(Capability::PLATFORM, $filtered);
        $this->assertArrayNotHasKey(Capability::VERSION, $filtered);
        $this->assertArrayNotHasKey(Capability::ACCEPT_SSL_CERTS, $filtered);
    }

    /**
     * Key-value mapping must be preserved (not reindexed numerically)
     */
    public function testSessionPreservesKeyValueMapping()
    {
        $driver = $this->createDriverWithMock();

        $driver->session(Browser::CHROME, [
            Capability::BROWSER_NAME => 'chrome',
            Capability::PLATFORM_NAME => 'linux',
            Capability::ACCEPT_INSECURE_CERTS => true,
        ]);

        $firstMatch = $this->capturedParameters['capabilities']['firstMatch'];
        $filtered = $firstMatch[0];

        // Keys must be string capability names, not numeric indices
        $firstKey = null;
        
        foreach ($filtered as $firstKey => $dontcare) {
            break;
        }
        
        $this->assertIsString($firstKey);
        $this->assertSame('chrome', $filtered[Capability::BROWSER_NAME]);
        $this->assertSame('linux', $filtered[Capability::PLATFORM_NAME]);
    }
}
