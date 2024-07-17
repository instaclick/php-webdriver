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
 * @method array handles() Get window handles.
 * @method array fullscreen() Fullscreen window.
 * @method array maximize() Maximize the window if not already maximized.
 * @method array minimize() Minimize window.
 * @method array getPosition() Get position of the window.
 * @method void postPosition($json) Change position of the window.
 * @method array getRect() Get window rect.
 * @method array postRect($json) Set window rect.
 */
class Window extends AbstractWebDriver
{
    const WEB_WINDOW_ID = 'window-fcc6-11e5-b4f8-330a88ab9d7f';

    /**
     * @var string
     */
    private $windowHandle;

    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return array(
            'handles' => array('GET'),
            'fullscreen' => array('POST'),
            'maximize' => array('POST'),
            'minimize' => array('POST'),
            'position' => array('GET', 'POST'),
            'rect' => array('GET', 'POST'),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function obsoleteMethods()
    {
        return array(
            // Legacy JSON Wire Protocol
            'size' => array('GET', 'POST'),
        );
    }

    /**
     * Constructor
     *
     * @param string      $url
     * @param string|null $windowHandle
     */
    public function __construct($url, $windowHandle = null)
    {
        parent::__construct($url);

        $this->windowHandle = $windowHandle;
    }

    /**
     * Get window handle: /session/:sessionId/window (GET)
     *                  : /session/:sessionId/window_handle (GET)
     * - $session->window($handle)->getHandle()
     * - $session->window()->getHandle()
     *
     * @return string
     */
    public function getHandle()
    {
        if (! $this->windowHandle) {
            $result = $this->curl('GET', $this->url);

            $this->windowHandle = array_key_exists(self::WEB_WINDOW_ID, $result['value'])
                ? $result['value'][self::WEB_WINDOW_ID]
                : $result['value'];
        }

        return $this->windowHandle;
    }

    /**
     * Close window: /session/:sessionId/window (DELETE)
     *
     * @return mixed
     */
    public function close()
    {
        $result = $this->curl('DELETE', '');

        return $result['value'];
    }
}
