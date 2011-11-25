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
 * WebDriver_Exception class
 *
 * @package WebDriver
 */
class WebDriver_Exception extends Exception {
	/**
	 * Response status codes
	 *
	 * @link http://code.google.com/p/selenium/wiki/JsonWireProtocol#Response_Status_Codes
	 */
	const Success = 0;
	const NoSuchElement = 7;
	const NoSuchFrame = 8;
	const UnknownCommand = 9;
	const StaleElementReference = 10;
	const ElementNotVisible = 11;
	const InvalidElementState = 12;
	const UnknownError = 13;
	const ElementIsNotSelectable = 15;
	const JavaScriptError = 17;
	const XPathLookupError = 19;
	const Timeout = 21;
	const NoSuchWindow = 23;
	const InvalidCookieDomain = 24;
	const UnableToSetCookie = 25;
	const UnexpectedAlertOpen = 26;
	const NoAlertOpenError = 27;
	const ScriptTimeout = 28;
	const InvalidElementCoordinates = 29;
	const IMENotAvailable = 30;
	const IMEEngineActivationFailed = 31;
	const InvalidSelector = 32;

	// obsolete
	const IndexOutOfBounds = 1;
	const NoCollection = 2;
	const NoString = 3;
	const NoStringLength = 4;
	const NoStringWrapper = 5;
	const NoSuchDriver = 6;
	const ObsoleteElement = 10;
	const ElementNotDisplayed = 11;
	const Unhandled = 13;
	const Expected = 14;
	const ElementNotSelectable = 15;
	const NoSuchDocument = 16;
	const UnexpectedJavaScript = 17;
	const NoScriptResult = 18;
	const NoSuchCollection = 20;
	const NullPointer = 22;
	const NoModalDialogOpenError = 27;

	// user-defined
	const CurlExec = -1;
	const ObsoleteCommand = -2;
	const NoParametersExpected = -3;
	const JsonParameterExpected = -4;
	const InvalidRequest = -5;
	const UnknownLocatorStrategy = -6;
	const WebTestAssertion = -7;

	private static $errs = array(
//	self::Success => array('Success', 'This should never be thrown!'),

		self::NoSuchElement => array('NoSuchElement', 'An element could not be located on the page using the given search parameters.'),
		self::NoSuchFrame => array('NoSuchFrame', 'A request to switch to a frame could not be satisfied because the frame could not be found.'),
		self::UnknownCommand => array('UnknownCommand', 'The requested resource could not be found, or a request was received using an HTTP method that is not supported by the mapped resource.'),
		self::StaleElementReference => array('StaleElementReference', 'An element command failed because the referenced element is no longer attached to the DOM.'),
		self::ElementNotVisible => array('ElementNotVisible', 'An element command could not be completed because the element is not visible on the page.'),
		self::InvalidElementState => array('InvalidElementState', 'An element command could not be completed because the element is in an invalid state (e.g. attempting to click a disabled element).'),
		self::UnknownError => array('UnknownError', 'An unknown server-side error occurred while processing the command.'),
		self::ElementIsNotSelectable => array('ElementIsNotSelectable', 'An attempt was made to select an element that cannot be selected.'),
		self::JavaScriptError => array('JavaScriptError', 'An error occurred while executing user supplied JavaScript.'),
		self::XPathLookupError => array('XPathLookupError', 'An error occurred while searching for an element by XPath.'),
		self::Timeout => array('Timeout', 'An operation did not complete before its timeout expired.'),
		self::NoSuchWindow => array('NoSuchWindow', 'A request to switch to a different window could not be satisfied because the window could not be found.'),
		self::InvalidCookieDomain => array('InvalidCookieDomain', 'An illegal attempt was made to set a cookie under a different domain than the current page.'),
		self::UnableToSetCookie => array('UnableToSetCookie', 'A request to set a cookie\'s value could not be satisfied.'),
		self::UnexpectedAlertOpen => array('UnexpectedAlertOpen', 'A modal dialog was open, blocking this operation'),
		self::NoAlertOpenError => array('NoAlertOpenError', 'An attempt was made to operate on a modal dialog when one was not open.'),
		self::ScriptTimeout => array('ScriptTimeout', 'A script did not complete before its timeout expired.'),
		self::InvalidElementCoordinates => array('InvalidElementCoordinates', 'The coordinates provided to an interactions operation are invalid.'),
		self::IMENotAvailable => array('IMENotAvailable', 'IME was not available.'),
		self::IMEEngineActivationFailed => array('IMEEngineActivationFailed', 'An IME engine could not be started.'),
		self::InvalidSelector => array('InvalidSelector', 'Argument was an invalid selector (e.g. XPath/CSS).'),

		self::CurlExec => array('CurlExec', 'curl_exec() error.'),
		self::ObsoleteCommand => array('ObsoleteCommand', 'This WebDriver command is obsolete.'),
		self::NoParametersExpected => array('NoParametersExpected', 'This HTTP request method expects no parameters.'),
		self::JsonParameterExpected => array('JsonParameterExpected', 'This POST request expects a JSON parameter (array).'),
		self::InvalidRequest => array('InvalidRequest', 'This command does not support this HTTP request method.'),
		self::UnknownLocatorStrategy => array('UnknownLocatorStrategy', 'This locator strategy is not supported.'),
		self::WebTestAssertion => array('WebTestAssertion', 'WebTest assertion failed.'),
	);

	/**
	 * Factory method to create WebDriver_Exception objects
	 *
	 * @param int $code
	 * @param string $message
	 * @param Exception $previous_exception
	 * @return WebDriver_Exception
	 */
	static function factory($code, $message = null, $previous_exception = null) {
		// unknown error
		if (!isset(self::$errs[$code])) {
			if (trim($message) == '') {
				$message = 'Unknown Error';
			}

			return new WebDriver_Exception($message, $code, $previous_exception);
		}

		$error_definition = self::$errs[$code];

		// dynamically define custom exception classes
		$class_name = __CLASS__ . '_' . $error_definition[0];
		if (!class_exists($class_name, false)) {
			eval(
				'final class '.$class_name.' extends WebDriver_Exception {}'
			);
		}

		if (trim($message) == '') {
			$message = $error_definition[1];
		}

		return new $class_name($message, $code, $previous_exception);
	}
}
