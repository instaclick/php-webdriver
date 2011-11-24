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
 * WebDriver_Session class
 *
 * @package WebDriver
 *
 * @method url
 * @method forward
 * @method back
 * @method refresh
 * @method execute
 * @method execute_async
 * @method screenshot
 * @method window_handle
 * @method window_handles
 * @method cookie
 * @method frame
 * @method source
 * @method title
 * @method keys
 * @method orientation
 * @method alert_text
 * @method accept_alert
 * @method dismiss_alert
 * @method moveto
 * @method click
 * @method buttondown
 * @method buttonup
 * @method doubleclick
 */
final class WebDriver_Session extends WebDriver_Container {
	/**
	 * Return array of supported method names and corresponding HTTP request types
	 *
	 * @return array
	 */
	protected function methods() {
		return array(
			'url' => array('GET', 'POST'), // alternate for POST, use open($url)
			'forward' => 'POST',
			'back' => 'POST',
			'refresh' => 'POST',
			'execute' => 'POST',
			'execute_async' => 'POST',
			'screenshot' => 'GET',
			'window_handle' => 'GET',
			'window_handles' => 'GET',
			'cookie' => array('GET', 'POST'), // for DELETE, use deleteAllCookies()
			'frame' => 'POST',
			'source' => 'GET',
			'title' => 'GET',
			'keys' => 'POST',
			'orientation' => array('GET', 'POST'),
			'alert_text' => array('GET', 'POST'),
			'accept_alert' => 'POST',
			'dismiss_alert' => 'POST',
			'moveto' => 'POST',
			'click' => 'POST',
			'buttondown' => 'POST',
			'buttonup' => 'POST',
			'doubleclick' => 'POST',
		);
	}

	/**
	 * Return array of obsolete method names and corresponding HTTP request types
	 *
	 * @return array
	 */
	protected function obsolete_methods() {
		return array(
			'modifier' => 'POST',
			'speed' => array('GET', 'POST'),
		);
	}

	/**
	 * Open URL: /session/:sessionId/url (POST)
	 * An alternative to $session->url($url);
	 *
	 * @param string $url
	 * @return WebDriver_Base
	 */
	public function open($url) {
		$this->curl('POST', '/url', is_array($url) ? $url : array('url' => $url));
		return $this;
	}

	/**
	 * Get browser capabilities: /session/:sessionId (GET)
	 *
	 * @return mixed
	 */
	public function capabilities() {
		return $this->curl('GET', '');
	}

	/**
	 * Close session: /session/:sessionId (DELETE)
	 *
	 * @return mixed
	 */
	public function close() {
		return $this->curl('DELETE', '');
	}

	// There's a limit to our ability to exploit the dynamic nature of PHP when it
	// comes to the cookie methods because GET and DELETE request types are indistinguishable
	// from each other, neither takes parameters.

	/**
	 * Get all cookies: /session/:sessionId/cookie (GET)
	 * Alternative to: $session->cookie();
	 *
	 * @return mixed
	 */
	public function getAllCookies() {
		return $this->curl('GET', '/cookie');
	}

	/**
	 * Set cookie: /session/:sessionId/cookie (POST)
	 * Alternative to: $session->cookie($cookie_json);
	 *
	 * @param array $cookie_json
	 * @return WebDriver_Base
	 */
	public function setCookie($cookie_json) {
		$this->curl('POST', '/cookie', is_array($cookie_json) ? $cookie_json : array('cookie' => $cookie_json));
		return $this;
	}

	/**
	 * Delete all cookies: /session/:sessionId/cookie (DELETE)
	 *
	 * @return WebDriver_Base
	 */
	public function deleteAllCookies() {
		$this->curl('DELETE', '/cookie');
		return $this;
	}

	/**
	 * Delete a cookie: /session/:sessionId/cookie/:name (DELETE)
	 *
	 * @param string $cookie_name
	 * @return WebDriver_Base
	 */
	public function deleteCookie($cookie_name) {
		$this->curl('DELETE', '/cookie/' . $cookie_name);
		return $this;
	}

	/**
	 * window methods: /session/:sessionId/window (POST, DELETE)
	 * - $session->window() - close current window
	 * - $session->window($name) - set focus
	 * - $session->window($window_handle)->method() - chaining
	 *
	 * @return WebDriver_Base
	 */
	public function window() {
		// close current window
		if (func_num_args() == 0)
		{
			$this->curl('DELETE', '/window');
			return $this;
		}

		// set focus
		$arg = func_get_arg(0); // window handle or name attribute
		if (is_array($arg)) {
			$this->curl('POST', '/window', $arg);
			return $this;
		}

		// chaining
		return new WebDriver_Window($this->url . '/window', $arg);
	}

	/**
	 * Delete window: /session/:sessionId/window (DELETE)
	 *
	 * @return WebDriver_Base
	 */
	public function deleteWindow() {
		$this->curl('DELETE', '/window');
		return $this;
	}

	/**
	 * Set focus to window: /session/:sessionId/window (POST)
	 *
	 * @param mixed $name window handlr or name attribute
	 * @return WebDriver_Base
	 */
	public function focusWindow($name) {
		$this->curl('POST', '/window', array('name' => $name));
		return $this;
	}

	/**
	 * timeouts method chaining, e.g.,
	 * - $session->timeouts()->method()
	 *
	 * @return WebDriver_Base
	 */
	public function timeouts() {
		$item = new WebDriver_SimpleItem($this->url . '/timeouts');
		return $item->setMethods(array(
			'async_script' => 'POST',
			'implicit_wait' => 'POST',
		));
	}

	/**
	 * ime method chaining, e.g.,
	 * - $session->ime()->method()
	 *
	 * @return WebDriver_Base
	 */
	public function ime() {
		$item = new WebDriver_SimpleItem($this->url . '/ime');
		return $item->setMethods(array(
			'available_engines' => 'GET',
			'active_engine' => 'GET',
			'activated' => 'GET',
			'deactivate' => 'POST',
			'activate' => 'POST',
		));
	}

	/**
	 * touch method chaining, e.g.,
	 * - $session->touch()->method()
	 *
	 * @return WebDriver_Base
	 */
	public function touch() {
		$item = new WebDriver_SimpleItem($this->url . '/touch');
		return $item->setMethods(array(
			'click' => 'POST',
			'down' => 'POST',
			'up' => 'POST',
			'move' => 'POST',
			'scroll' => 'POST',
			'doubleclick' => 'POST',
			'longclick' => 'POST',
			'flick' => 'POST',
		));
	}

	/**
	 * Get wire protocol URL for an element
	 *
	 * @param string $element_id
	 * @return string
	 */
	protected function getElementPath($element_id) {
		return sprintf('%s/element/%s', $this->url, $element_id);
	}
}
