<?php
// Copyright 2004-present Facebook. All Rights Reserved.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

final class WebDriver_Session extends WebDriver_Container {
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

      // obsolete/deprecated
      'modifier' => 'POST',
      'speed' => array('GET', 'POST'),
    );
  }

  // /session/:sessionId/url (POST)
  public function open($url) {
    $this->curl('POST', '/url', is_array($url) ? $url : array('url' => $url));
    return $this;
  }

  // /session/:sessionId (GET)
  public function capabilities() {
    return $this->curl('GET', '');
  }

  // /session/:sessionId (DELETE)
  public function close() {
    return $this->curl('DELETE', '');
  }

  // /session/:sessionId/cookie (GET)
  public function getAllCookies() {
    return $this->curl('GET', '/cookie');
  }

  // /session/:sessionId/cookie (POST)
  public function setCookie($cookie_json) {
    $this->curl('POST', '/cookie', is_array($cookie_json) ? $cookie_json : array('cookie' => $cookie_json));
    return $this;
  }

  // /session/:sessionId/cookie (DELETE)
  public function deleteAllCookies() {
    $this->curl('DELETE', '/cookie');
    return $this;
  }

  // /session/:sessionId/cookie/:name (DELETE)
  public function deleteCookie($cookie_name) {
    $this->curl('DELETE', '/cookie/' . $cookie_name);
    return $this;
  }

  // /session/:sessionId/window (POST, DELETE)
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

  public function timeouts() {
    $item = new WebDriver_SimpleItem($this->url . '/timeouts');
    return $item->setMethods(array(
      'async_script' => 'POST',
      'implicit_wait' => 'POST',
    ));
  }

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

  protected function getElementPath($element_id) {
    return sprintf('%s/element/%s', $this->url, $element_id);
  }
}