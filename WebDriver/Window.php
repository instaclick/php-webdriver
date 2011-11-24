<?php
/**
 * Copyright 2011 Anthon Pang. All Rights Reserved.
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
 * WebDriver_Window class
 *
 * @package WebDriver
 */
final class WebDriver_Window extends WebDriver_Base {
  /**
   * Return array of supported method names and corresponding HTTP request types
   *
   * @return array
   */
  protected function methods() {
    return array(
      'size' => array('GET', 'POST'),
      'position' => array('GET', 'POST'),
    );
  }

  private $handle;

  /**
   * Get window handle
   *
   * @return string
   */
  public function getHandle() {
    return $this->handle;
  }

  /**
   * Constructor
   *
   * @param string $url
   * @param string $window_handle
   */
  public function __construct($url, $window_handle) {
    $this->handle = $window_handle;

    parent::__construct($url . '/' . $window_handle);
  }
}
