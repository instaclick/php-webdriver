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
 * WebDriver_Keys class
 *
 * @package WebDriver
 */
final class WebDriver_Keys {
  /*
   * The Unicode "Private Use Area" code points (0xE000-0xF8FF) are used to represent
   * pressable, non-text keys.
   */
  static private $key_strokes = array(
    'NULL' => "\xE0\x00",
    'Cancel' => "\xE0\x01",
    'Help' => "\xE0\x02",
    'Back space' => "\xE0\x03",
    'Tab' => "\xE0\x04",
    'Clear' => "\xE0\x05",
    'Return1' => "\xE0\x06",
    'Enter1' => "\xE0\x07",
    'Shift' => "\xE0\x08",
    'Control' => "\xE0\x09",
    'Alt' => "\xE0\x0A",
    'Pause' => "\xE0\x0B",
    'Escape' => "\xE0\x0C",
    'Space' => "\xE0\x0D",
    'Pageup' => "\xE0\x0E",
    'Pagedown' => "\xE0\x0F",
    'End' => "\xE0\x10",
    'Home' => "\xE0\x11",
    'Left arrow' => "\xE0\x12",
    'Up arrow' => "\xE0\x13",
    'Right arrow' => "\xE0\x14",
    'Down arrow' => "\xE0\x15",
    'Insert' => "\xE0\x16",
    'Delete' => "\xE0\x17",
    'Semicolon' => "\xE0\x18",
    'Equals' => "\xE0\x19",
    'Numpad 0' => "\xE0\x1A",
    'Numpad 1' => "\xE0\x1B",
    'Numpad 2' => "\xE0\x1C",
    'Numpad 3' => "\xE0\x1D",
    'Numpad 4' => "\xE0\x1E",
    'Numpad 5' => "\xE0\x1F",
    'Numpad 6' => "\xE0\x20",
    'Numpad 7' => "\xE0\x21",
    'Numpad 8' => "\xE0\x22",
    'Numpad 9' => "\xE0\x23",
    'Multiply' => "\xE0\x24",
    'Add' => "\xE0\x25",
    'Separator' => "\xE0\x26",
    'Subtract' => "\xE0\x27",
    'Decimal' => "\xE0\x28",
    'Divide' => "\xE0\x29",
    'F1' => "\xE0\x31",
    'F2' => "\xE0\x32",
    'F3' => "\xE0\x33",
    'F4' => "\xE0\x34",
    'F5' => "\xE0\x35",
    'F6' => "\xE0\x36",
    'F7' => "\xE0\x37",
    'F8' => "\xE0\x38",
    'F9' => "\xE0\x39",
    'F10' => "\xE0\x3A",
    'F11' => "\xE0\x3B",
    'F12' => "\xE0\x3C",
    'Command/Meta' => "\xE0\x3D",
  );

  /**
   * Get key stroke code for pressable, non-text keys
   *
   * @link http://code.google.com/p/selenium/wiki/JsonWireProtocol#/session/:sessionId/element/:id/value
   *
   * @param string $key
   * @return string
   */
  static function key($key) {
    if (!isset(self::$key_strokes[$key])) {
      return '';
    }

    return iconv('UCS-2', 'UTF-8', self::$key_strokes[$key]);
  }
}
