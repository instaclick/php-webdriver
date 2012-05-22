<?php
/**
 * Copyright 2004-2012 Facebook. All Rights Reserved.
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
 * @author Justin Bishop <jubishop@gmail.com>
 * @author Anthon Pang <anthonp@nationalfibre.net>
 * @author Fabrizio Branca <mail@fabrizio-branca.de>
 */

/**
 * @package WebDriver
 */
require_once(__DIR__ . '/AppCacheStatus.php');
require_once(__DIR__ . '/Browser.php');
require_once(__DIR__ . '/Capability.php');
require_once(__DIR__ . '/Key.php');
require_once(__DIR__ . '/LocatorStrategy.php');
require_once(__DIR__ . '/AbstractWebDriver.php');
require_once(__DIR__ . '/WebDriver.php');
require_once(__DIR__ . '/ApplicationCache.php');
require_once(__DIR__ . '/Container.php');
require_once(__DIR__ . '/Session.php');
require_once(__DIR__ . '/Element.php');
require_once(__DIR__ . '/Exception.php');
require_once(__DIR__ . '/Ime.php');
require_once(__DIR__ . '/Timeouts.php');
require_once(__DIR__ . '/Touch.php');
require_once(__DIR__ . '/Window.php');
require_once(__DIR__ . '/Storage.php');
require_once(__DIR__ . '/SauceLabs/Capability.php');
require_once(__DIR__ . '/SauceLabs/SauceRest.php');
require_once(__DIR__ . '/Service/CurlServiceInterface.php');
require_once(__DIR__ . '/Service/CurlService.php');
require_once(__DIR__ . '/ServiceFactory.php');
require_once(__DIR__ . '/WebTest/Script.php');
require_once(__DIR__ . '/WebTest/WebTest.php');
