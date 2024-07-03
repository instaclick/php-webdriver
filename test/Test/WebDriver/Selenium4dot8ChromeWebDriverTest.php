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
class Selenium4dot8ChromeWebDriverTest extends Selenium4ChromeWebDriverTest
{
    protected $testWebDriverRootUrl = 'http://oldchrome:4444';
}
