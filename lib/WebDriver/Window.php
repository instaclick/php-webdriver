<?php

/**
 * Copyright 2011-2022 Anthon Pang. All Rights Reserved.
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
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 * @author Fabrizio Branca <mail@fabrizio-branca.de>
 */

namespace WebDriver;

/**
 * WebDriver\Window class
 *
 * @package WebDriver
 *
 * @method array handles() Get Window Handles
 * @method array fullscreen() Fullscreen Window
 * @method array maximize() Maximize the window if not already maximized.
 * @method array minimize() Minimize Window
 * @method array getPosition() Get position of the window.
 * @method void postPosition($json) Change position of the window.
 * @method array getRect() Get Window Rect
 * @method array postRect() Set Window Rect
 * @method array getSize() Get Window Size
 * @method array postSize() Set Window Size
 */
final class Window extends AbstractWebDriver
{
    const WEBDRIVER_WINDOW_ID = 'window-fcc6-11e5-b4f8-330a88ab9d7f';

    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return array(
            'handles' => array('GET'),
            'fullscreen' => array('POST'),
            'maximize' => array('POST'),
            'position' => array('GET', 'POST'),
            'size' => array('GET', 'POST'),

            // obsolete
            'minimize' => array('POST'),
            'rect' => array('GET', 'POST'),
        );
    }

    /**
     * Get window handle
     *
     * @return string
     */
    public function getHandle()
    {
        $result = $this->curl('GET', $this->url);

        return array_key_exists(self::WEBDRIVER_WINDOW_ID, $result['value'])
            ? $result['value'][self::WEBDRIVER_WINDOW_ID]
            : $result['value'];
    }

    /**
     * New window: /session/:sessionId/window/new (POST)
     *
     * @deprecated
     *
     * @param string $name
     *
     * @return \WebDriver\Window
     */
    public function focusWindow($name)
    {
        $this->curl('POST', '/new');

        return $this;
    }
}
