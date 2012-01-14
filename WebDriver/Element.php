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
 * WebDriver_Element class
 *
 * @package WebDriver
 *
 * @method click
 * @method submit
 * @method text
 * @method value
 * @method name
 * @method clear
 * @method selected
 * @method enabled
 * @method attribute
 * @method equals
 * @method displayed
 * @method location
 * @method location_in_view
 * @method size
 * @method css
 */
final class WebDriver_Element extends WebDriver_Container {
	/*
	 * The Unicode "Private Use Area" code points (0xE000-0xF8FF) are used to represent
	 * pressable, non-text keys.
	 *
	 * @link http://code.google.com/p/selenium/wiki/JsonWireProtocol#/session/:sessionId/element/:id/value
	 *    key_name   = "UTF-8";        // UCS-2
	 */
	const NullKey    = "\xEE\x80\x80"; // E000
	const Cancel     = "\xEE\x80\x81"; // E001
	const Help       = "\xEE\x80\x82"; // E002
	const BackSpace  = "\xEE\x80\x83"; // E003
	const Tab        = "\xEE\x80\x84"; // E004
	const Clear      = "\xEE\x80\x85"; // E005
	const ReturnKey  = "\xEE\x80\x86"; // E006
	const Enter      = "\xEE\x80\x87"; // E007
	const Shift      = "\xEE\x80\x88"; // E008
	const Control    = "\xEE\x80\x89"; // E009
	const Alt        = "\xEE\x80\x8A"; // E00A
	const Pause      = "\xEE\x80\x8B"; // E00B
	const Escape     = "\xEE\x80\x8C"; // E00C
	const Space      = "\xEE\x80\x8D"; // E00D
	const PageUp     = "\xEE\x80\x8E"; // E00E
	const PageDown   = "\xEE\x80\x8F"; // E00F
	const End        = "\xEE\x80\x90"; // E010
	const Home       = "\xEE\x80\x91"; // E011
	const LeftArrow  = "\xEE\x80\x92"; // E012
	const UpArrow    = "\xEE\x80\x93"; // E013
	const RightArrow = "\xEE\x80\x94"; // E014
	const DownArrow  = "\xEE\x80\x95"; // E015
	const Insert     = "\xEE\x80\x96"; // E016
	const Delete     = "\xEE\x80\x97"; // E017
	const Semicolon  = "\xEE\x80\x98"; // E018
	const Equals     = "\xEE\x80\x99"; // E019
	const Numpad0    = "\xEE\x80\x9A"; // E01A
	const Numpad1    = "\xEE\x80\x9B"; // E01B
	const Numpad2    = "\xEE\x80\x9C"; // E01C
	const Numpad3    = "\xEE\x80\x9D"; // E01D
	const Numpad4    = "\xEE\x80\x9E"; // E01E
	const Numpad5    = "\xEE\x80\x9F"; // E01F
	const Numpad6    = "\xEE\x80\xA0"; // E020
	const Numpad7    = "\xEE\x80\xA1"; // E021
	const Numpad8    = "\xEE\x80\xA2"; // E022
	const Numpad9    = "\xEE\x80\xA3"; // E023
	const Multiply   = "\xEE\x80\xA4"; // E024
	const Add        = "\xEE\x80\xA5"; // E025
	const Separator  = "\xEE\x80\xA6"; // E026
	const Subtract   = "\xEE\x80\xA7"; // E027
	const Decimal    = "\xEE\x80\xA8"; // E028
	const Divide     = "\xEE\x80\xA9"; // E029
	const F1         = "\xEE\x80\xB1"; // E031
	const F2         = "\xEE\x80\xB2"; // E032
	const F3         = "\xEE\x80\xB3"; // E033
	const F4         = "\xEE\x80\xB4"; // E034
	const F5         = "\xEE\x80\xB5"; // E035
	const F6         = "\xEE\x80\xB6"; // E036
	const F7         = "\xEE\x80\xB7"; // E037
	const F8         = "\xEE\x80\xB8"; // E038
	const F9         = "\xEE\x80\xB9"; // E039
	const F10        = "\xEE\x80\xBA"; // E03A
	const F11        = "\xEE\x80\xBB"; // E03B
	const F12        = "\xEE\x80\xBC"; // E03C
	const Command    = "\xEE\x80\xBD"; // E03D
	const Meta       = "\xEE\x80\xBD"; // E03D

	/**
	 * Return array of supported method names and corresponding HTTP request types
	 *
	 * @return array
	 */
	protected function methods() {
		return array(
			'click' => 'POST',
			'submit' => 'POST',
			'text' => 'GET',
			'value' => 'POST',
			'name' => 'GET',
			'clear' => 'POST',
			'selected' => 'GET',
			'enabled' => 'GET',
			'attribute' => 'GET',
			'equals' => 'GET',
			'displayed' => 'GET',
			'location' => 'GET',
			'location_in_view' => 'GET',
			'size' => 'GET',
			'css' => 'GET',
		);
	}

	/**
	 * Return array of obsolete method names and corresponding HTTP request types
	 *
	 * @return array
	 */
	protected function obsolete_methods() {
		return array(
			'value' => 'GET',
			'selected' => 'POST',
			'toggle' => 'POST',
			'hover' => 'POST',
			'drag' => 'POST',
		);
	}

	protected $url;
	private $id;

	/**
	 * Constructor
	 *
	 * @param string $url
	 * @param string $id element ID
	 */
	public function __construct($url, $id) {
		$this->id = $id;
		parent::__construct($url);
	}

	/**
	 * Get element ID
	 *
	 * @return string
	 */
	public function getID() {
		return $this->id;
	}

	/**
	 * Get wire protocol URL for an element
	 *
	 * @param string $element_id
	 * @return string
	 */
	protected function getElementPath($element_id) {
		return preg_replace(sprintf('/%s$/', $this->id), $element_id, $this->url);
	}
}
