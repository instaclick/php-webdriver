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
 * Abstract WebDriver_Base class
 *
 * @package WebDriver
 */
abstract class WebDriver_Base {
	/**
	 * Return array of supported method names and corresponding HTTP request types
	 *
	 * @return array
	 */
	abstract protected function methods();

	/**
	 * Return array of obsolete method names and corresponding HTTP request types
	 *
	 * @return array
	 */
	protected function obsolete_methods() {
		return array();
	}

	protected $url;

	/**
	 * Constructor
	 *
	 * @param string $url URL to Selenium server
	 */
	public function __construct($url = 'http://localhost:4444/wd/hub') {
		$this->url = $url;
	}

	/**
	 * Magic method which returns URL to Selenium server
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->url;
	}

	/**
	 * Returns URL to Selenium server
	 *
	 * @return string
	 */
	public function getURL() {
		return $this->url;
	}

	/**
	 * Curl request to webdriver server.
	 *
	 * @param string $http_method  'GET', 'POST', or 'DELETE'
	 * @param string $command      If not defined in methods() this function will throw.
	 * @param array  $params       If an array(), they will be posted as JSON parameters
	 *                             If a number or string, "/$params" is appended to url
	 * @param array  $extra_opts   key=>value pairs of curl options to pass to curl_setopt()
	 * @return array               array('value' => ..., 'info' => ...)
	 * @throws WebDriver_Exception if error
	 */
	protected function curl($http_method, $command, $params = null, $extra_opts = array()) {
		if ($params && is_array($params) && $http_method !== 'POST') {
			throw WebDriver_Exception::factory(WebDriver_Exception::NoParametersExpected, sprintf(
				'The http method called for %s is %s but it has to be POST' .
				' if you want to pass the JSON params %s',
				$command,
				$http_method,
				json_encode($params)
			));
		}

		$url = sprintf('%s%s', $this->url, $command);
		if ($params && (is_int($params) || is_string($params))) {
			$url .= '/' . $params;
		}

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('application/json;charset=UTF-8'));

		if ($http_method === 'POST') {
			curl_setopt($curl, CURLOPT_POST, true);
			if ($params && is_array($params)) {
				curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
			}
		} else if ($http_method == 'DELETE') {
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
		}

		foreach ($extra_opts as $option => $value) {
			curl_setopt($curl, $option, $value);
		}

		$raw_results = trim(WebDriver_Environment::CurlExec($curl));
		$info = curl_getinfo($curl);

		if ($error = curl_error($curl)) {
			$msg = sprintf(
				'Curl error thrown for http %s to %s',
				$http_method,
				$url
			);
			if ($params && is_array($params)) {
				$msg .= sprintf(' with params: %s', json_encode($params));
			}
			throw WebDriver_Exception::factory(WebDriver_Exception::CurlExec, $msg . "\n\n" . $error);
		}
		curl_close($curl);

		$results = json_decode($raw_results, true);

		$value = null;
		if (is_array($results) && array_key_exists('value', $results)) {
			$value = $results['value'];
		}

		$message = null;
		if (is_array($value) && array_key_exists('message', $value)) {
			$message = $value['message'];
		}

		// if not success, throw exception
		if ($results['status'] != 0) {
			throw WebDriver_Exception::factory($results['status'], $message);
		}

		return array('value' => $value, 'info' => $info);
	}

	/**
	 * Magic method that maps calls to class methods to execute WebDriver commands
	 *
	 * @param string $name
	 * @param array $arguments
	 * @return mixed
	 */
	public function __call($name, $arguments) {
		if (count($arguments) > 1) {
			throw WebDriver_Exception::factory(WebDriver_Exception::JsonParameterExpected,
				'Commands should have at most only one parameter,' .
				' which should be the JSON Parameter object'
			);
		}

		if (preg_match('/^(get|post|delete)/', $name, $matches)) {
			$http_method = strtoupper($matches[0]);
			$webdriver_command = strtolower(substr($name, strlen($http_method)));
		} else if (count($arguments) > 0) {
			$webdriver_command = $name;
			$this->getHTTPMethod($webdriver_command);
			$http_method = 'POST';
		} else {
			$webdriver_command = $name;
			$http_method = $this->getHTTPMethod($webdriver_command);
		}

		$methods = $this->methods();
		if (!in_array($http_method, (array) $methods[$webdriver_command])) {
			throw WebDriver_Exception::factory(WebDriver_Exception::InvalidRequest, sprintf(
				'%s is not an available http method for the command %s.',
				$http_method,
				$webdriver_command
			));
		}

		$results = $this->curl(
			$http_method,
			'/' . $webdriver_command,
			array_shift($arguments)
		);

		return $results['value'];
	}

	/**
	 * Get default HTTP method for a given WebDriver command
	 *
	 * @param string $webdriver_command
	 * @return string
	 * @throws Exception if invalid WebDriver command
	 */
	private function getHTTPMethod($webdriver_command) {
		if (!array_key_exists($webdriver_command, $this->methods())) {
			if (array_key_exists($webdriver_command, $this->obsolete_methods())) {
				throw WebDriver_Exception::factory(WebDriver_Exception::ObsoleteCommand,
					sprintf('%s is an obsolete WebDriver command.', $webdriver_command)
				);
			} else {
				throw WebDriver_Exception::factory(WebDriver_Exception::UnknownCommand,
					sprintf('%s is not a valid WebDriver command.', $webdriver_command)
				);
			}
		}

		$methods = $this->methods();
		$http_methods = (array) $methods[$webdriver_command];
		return array_shift($http_methods);
	}
}
