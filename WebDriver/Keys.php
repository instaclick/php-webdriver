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
    'NULL' => 'E000',
    'Cancel' => 'E001',
    'Help' => 'E002',
    'Back space' => 'E003',
    'Tab' => 'E004',
    'Clear' => 'E005',
    'Return1' => 'E006',
    'Enter1' => 'E007',
    'Shift' => 'E008',
    'Control' => 'E009',
    'Alt' => 'E00A',
    'Pause' => 'E00B',
    'Escape' => 'E00C',
    'Space' => 'E00D',
    'Pageup' => 'E00E',
    'Pagedown' => 'E00F',
    'End' => 'E010',
    'Home' => 'E011',
    'Left arrow' => 'E012',
    'Up arrow' => 'E013',
    'Right arrow' => 'E014',
    'Down arrow' => 'E015',
    'Insert' => 'E016',
    'Delete' => 'E017',
    'Semicolon' => 'E018',
    'Equals' => 'E019',
    'Numpad 0' => 'E01A',
    'Numpad 1' => 'E01B',
    'Numpad 2' => 'E01C',
    'Numpad 3' => 'E01D',
    'Numpad 4' => 'E01E',
    'Numpad 5' => 'E01F',
    'Numpad 6' => 'E020',
    'Numpad 7' => 'E021',
    'Numpad 8' => 'E022',
    'Numpad 9' => 'E023',
    'Multiply' => 'E024',
    'Add' => 'E025',
    'Separator' => 'E026',
    'Subtract' => 'E027',
    'Decimal' => 'E028',
    'Divide' => 'E029',
    'F1' => 'E031',
    'F2' => 'E032',
    'F3' => 'E033',
    'F4' => 'E034',
    'F5' => 'E035',
    'F6' => 'E036',
    'F7' => 'E037',
    'F8' => 'E038',
    'F9' => 'E039',
    'F10' => 'E03A',
    'F11' => 'E03B',
    'F12' => 'E03C',
    'Command/Meta' => 'E03D',
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
