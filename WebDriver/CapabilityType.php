<?php
/**
 * Copyright 2011 Fabrizio Branca. All Rights Reserved.
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
 */

/**
 * WebDriver_CapabilityType class
 *
 * @package WebDriver
 */
final class WebDriver_CapabilityType {

	/**
	 * @see http://code.google.com/p/selenium/source/browse/trunk/java/client/src/org/openqa/selenium/remote/CapabilityType.java
	 * @see http://code.google.com/p/selenium/wiki/JsonWireProtocol#Capabilities_JSON_Object
	 */
	const BROWSER_NAME                      = 'browserName';
	const PLATFORM                          = 'platform';
	const SUPPORTS_JAVASCRIPT               = 'javascriptEnabled';
	const TAKES_SCREENSHOT                  = 'takesScreenshot';
	const VERSION                           = 'version';
	const SUPPORTS_ALERTS                   = 'handlesAlerts';
	const SUPPORTS_SQL_DATABASE             = 'databaseEnabled';
	const SUPPORTS_LOCATION_CONTEXT         = 'locationContextEnabled';
	const SUPPORTS_APPLICATION_CACHE        = 'applicationCacheEnabled';
	const SUPPORTS_BROWSER_CONNECTION       = 'browserConnectionEnabled';
	const SUPPORTS_FINDING_BY_CSS           = 'cssSelectorsEnabled';
	const PROXY                             = 'proxy';
	const SUPPORTS_WEB_STORAGE              = 'webStorageEnabled';
	const ROTATABLE                         = 'rotatable';

	// Enable this capability to accept all SSL certs by defaults.
	const ACCEPT_SSL_CERTS                  = 'acceptSslCerts';
	const HAS_NATIVE_EVENTS                 = 'nativeEvents';

	// For Selenium Server
	const AVOIDING_PROXY                    = 'avoidProxy';
	const ONLY_PROXYING_SELENIUM_TRAFFIC    = 'onlyProxySeleniumTraffic';
	const PROXYING_EVERYTHING               = 'proxyEverything';
	const PROXY_PAC                         = 'proxy_pac';
	const ENSURING_CLEAN_SESSION            = 'ensureCleanSession';
}
