<?php
/**
 * Copyright 2004-present Facebook. All Rights Reserved.
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
 * WebDriver class
 *
 * @package WebDriver
 *
 * @method status
 * @method sessions
 */
final class WebDriver extends WebDriver_Base {
	/**
	 * Return array of supported method names and corresponding HTTP request types
	 *
	 * @return array
	 */
	protected function methods() {
		return array(
			'status' => 'GET',
			'sessions' => 'POST',
		);
	}

	/**
	 * Get session object for chaining
	 *
	 * @param string $browser
	 * @param array $additional_capabilities
	 * @return WebDriver_Session
	 */
	public function session($browser = WebDriver_BrowserName::FIREFOX, $additional_capabilities = array()) {
		$desired_capabilities = array_merge(
			$additional_capabilities,
			array(WebDriver_CapabilityType::BROWSER_NAME => $browser)
		);

		$results = $this->curl(
			'POST',
			'/session',
			array('desiredCapabilities' => $desired_capabilities),
			array(CURLOPT_FOLLOWLOCATION => true)
		);

		return new WebDriver_Session($results['info']['url']);
	}
}
