<?php
/**
 * Copyright 2011-2012 Anthon Pang. All Rights Reserved.
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
 *
 * @author Anthon Pang <anthonp@nationalfibre.net>
 */

/**
 * WebDriver_Touch class
 *
 * @package WebDriver
 *
 * @method click
 * @method down
 * @method up
 * @method move
 * @method scroll
 * @method doubleclick
 * @method longclick
 * @method flick
 */
final class WebDriver_Touch extends WebDriver_Base
{
    /**
     * Return array of supported method names and corresponding HTTP request types
     *
     * @return array
     */
    protected function methods()
    {
        return array(
            'click' => array('POST'),
            'down' => array('POST'),
            'up' => array('POST'),
            'move' => array('POST'),
            'scroll' => array('POST'),
            'doubleclick' => array('POST'),
            'longclick' => array('POST'),
            'flick' => array('POST'),
        );
    }
}
