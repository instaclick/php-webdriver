<?php

/**
 * @copyright 2011 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
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
class Window extends AbstractWebDriver
{
    const WEB_WINDOW_ID = 'window-fcc6-11e5-b4f8-330a88ab9d7f';

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

        return array_key_exists(self::WEB_WINDOW_ID, $result['value'])
            ? $result['value'][self::WEB_WINDOW_ID]
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
