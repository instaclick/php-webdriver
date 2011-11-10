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
  /**
   * Search for element on page, starting from the document root.
   *
   * @param string $using the locator strategy to use
   * @param string $value the search target
   * @return WebDriver_Element
   * @throws WebDriver_Exception if element not found, or invalid XPath
   */
  public function element() {
    $this->parseArgs('element', func_get_args(), $using, $value);

    try {
      $results = $this->curl(
        'POST',
        '/element',
        array(
          'using' => $using,
          'value' => $value));
    } catch (WebDriver_Exception_NoSuchElement $e) {
      throw WebDriver_Exception::factory(WebDriver_Exception::NoSuchElement,
        sprintf(
          'Element not found with %s, %s',
          $using,
          $value) . "\n\n" . $e->getMessage(), $e);
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
    $this->parseArgs('elements', func_get_args(), $using, $value);

    $results = $this->curl(
      'POST',
      '/elements',
      array(
        'using' => $using,
        'value' => $value
      ));

    return array_filter(array_map(
      array($this, 'webDriverElement'), $results['value']));
  }

  /**
   * Parse arguments allowing either separate $using and $value parameters, or
   * as an array containing the JSON parameters
   *
   * @param string $method method name
   * @param array $argv arguments
   * @param string &$using
   * @param string &$value
   * @throws Exception if invalid number of arguments to the called method
   */
  private function parseArgs($method, $argv, &$using, &$value) {
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
          sprintf('Invalid arguments to %s method: %s', $method, print_r($argv, true)));
    }
  }

  /**
   * Return WebDriver_Element wrapper for $value
   *
   * @param mixed $value
   * @return WebDriver_Element|null
   */
  private function webDriverElement($value) {
    return (array_key_exists('ELEMENT', (array) $value)) ?
      new WebDriver_Element(
        $this->getElementPath($value['ELEMENT']),
        $value['ELEMENT']) :
      null;
  }

  /**
   * Get wire protocol URL for an element
   *
   * @param string $element_id
   * @return string
   */
  abstract protected function getElementPath($element_id);
}
