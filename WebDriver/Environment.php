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

// For security reasons some enterprises don't allow the use of some built-in
// php functions.  This class is meant to be a proxy for these functions.
// Modify these as necessary for your enviroment, and then .gitignore this file
// so you can still easily git pull other changes from the main github repo.

/**
 * WebDriver_Environment class
 *
 * @package WebDriver
 */
final class WebDriver_Environment {
  /**
   * Proxy method for curl_exec
   *
   * @param resource $ch curl handle
   */
  public static function CurlExec($ch) {
    return curl_exec($ch);
  }
}
