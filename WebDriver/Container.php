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
 * Abstract WebDriver_Container class
 *
 * @package WebDriver
 */
abstract class WebDriver_Container extends WebDriver_Base {

	const BY_CLASSNAME = 'class name';
	const BY_CSS = 'css selector';
	const BY_ID = 'id';
	const BY_NAME = 'name';
	const BY_LINKTEXT = 'link text';
	const BY_PARTIALLINKTEXT = 'partial link text';
	const BY_TAG = 'tag name';
	const BY_XPATH = 'xpath';

	/**
	 * Locator strategies
	 */
	private static $strategies = array(
		self::BY_CLASSNAME,
		self::BY_CSS,
		self::BY_ID,
		self::BY_NAME,
		self::BY_LINKTEXT,
		self::BY_PARTIALLINKTEXT,
		self::BY_NAME,
		self::BY_XPATH,
	);

	/**
	 * Search for element on page, starting from the document root.
	 *
	 * @param string $using the locator strategy to use
	 * @param string $value the search target
	 * @return WebDriver_Element
	 * @throws WebDriver_Exception if element not found, or invalid XPath
	 */
	public function element() {
		$locator_json = $this->parseArgs('element', func_get_args());

		try {
			$results = $this->curl(
				'POST',
				'/element',
				$locator_json
			);
		} catch (WebDriver_Exception_NoSuchElement $e) {
			throw WebDriver_Exception::factory(WebDriver_Exception::NoSuchElement,
				sprintf(
					'Element not found with %s, %s',
					$locator_json['using'],
					$locator_json['value']) . "\n\n" . $e->getMessage(), $e
			);
		}

		return $this->webDriverElement($results['value']);
	}

	/**
	 * Search for multiple elements on page, starting from the document root.
	 *
	 * @param string $using the locator strategy to use
	 * @param string $value the search target
	 * @return array
	 * @throws WebDriver_Exception if invalid XPath
	 */
	public function elements() {
		$locator_json = $this->parseArgs('elements', func_get_args());

		$results = $this->curl(
			'POST',
			'/elements',
			$locator_json
		);

		return array_filter(array_map(
			array($this, 'webDriverElement'), $results['value']
		));
	}

	/**
	 * Parse arguments allowing either separate $using and $value parameters, or
	 * as an array containing the JSON parameters
	 *
	 * @param string $method method name
	 * @param array $argv arguments
	 * @return array
	 * @throws Exception if invalid number of arguments to the called method
	 */
	private function parseArgs($method, $argv) {
		$argc = count($argv);

		switch ($argc) {
			case 2:
				$using = $argv[0];
				$value = $argv[1];
				break;

			case 1:
				$arg = $argv[0];
				if (is_array($arg)) {
					$using = $arg['using'];
					$value = $arg['value'];
					break;
				}

			default:
				throw WebDriver_Exception::factory(WebDriver_Exception::JsonParameterExpected,
					sprintf('Invalid arguments to %s method: %s', $method, print_r($argv, true))
				);
		}

		return $this->by($using, $value);
	}

	/**
	 * Return JSON parameter for element / elements command
	 *
	 * @param string $using locator strategy
	 * @param string $value search target
	 * @return array
	 */
	public function by($using, $value) {
		if (!in_array($using, self::$strategies)) {
			throw WebDriver_Exception::factory(WebDriver_Exception::UnknownLocatorStrategy,
				sprintf('Invalid locator strategy %s', $using)
			);
		}

		return array(
			'using' => $using,
			'value' => $value,
		);
	}

	/**
	 * Return WebDriver_Element wrapper for $value
	 *
	 * @param mixed $value
	 * @return WebDriver_Element|null
	 */
	private function webDriverElement($value) {
		return (array_key_exists('ELEMENT', (array) $value))
			? new WebDriver_Element( $this->getElementPath($value['ELEMENT']), $value['ELEMENT'])
			: null;
	}

	/**
	 * Magic method that maps calls to class methods to element locator strategies
	 *
	 * @param string $name
	 * @param array $arguments
	 * @return mixed
	 */
	public function __call($name, $arguments) {
		if (count($arguments) == 1 && in_array(str_replace('_', ' ', $name), self::$strategies)) {
			return $this->by($name, $arguments[0]);
		}

		// fallback to executing WebDriver commands
		return parent::__call($name, $arguments);
	}

	/**
	 * Get wire protocol URL for an element
	 *
	 * @param string $element_id
	 * @return string
	 */
	abstract protected function getElementPath($element_id);
}
