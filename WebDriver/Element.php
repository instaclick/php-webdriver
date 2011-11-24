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
 */
final class WebDriver_Element extends WebDriver_Container {
	/**
	 * Return array of supported method names and corresponding HTTP request types
	 *
	 * @return array
	 */
	protected function methods() {
		return array(
			'active' => 'POST',
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
