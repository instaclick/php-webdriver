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
 * W3C
 * @method array fullscreen() Fullscreen window.
 * @method array maximize() Maximize the window if not already maximized.
 * @method array minimize() Minimize window.
 * @method array getRect() Get window rect.
 * @method array postRect($parameters) Set window rect.
 * Selenium
 * @method array getPosition() Get window position.
 * @method array postPosition($parameters) Set window position.
 * @method array getSize() Get window size.
 * @method array postSize($parameters) Set window size.
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
        return [
            'fullscreen' => ['POST'],
            'maximize'   => ['POST'],
            'minimize'   => ['POST'],
            'rect'       => ['GET', 'POST'],

            // @deprecated
            'position'   => ['GET', 'POST'],
            'size'       => ['GET', 'POST'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return [
            'getPosition'  => 'getRect',
            'getSize'      => 'getRect',
            'postPosition' => 'setRect',
            'postSize'     => 'sesRect',
            'setPosition'  => 'setRect',
            'setSize'      => 'setRect',
        ];
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
     * Set window rect: /session/:sessionId/window/rect (POST)
     *
     * @param array $parameters Parameters {width: ..., height: ..., x: ..., y: ...}
     *
     * @return mixed
     */
    public function setRect($parameters)
    {
        $result = $this->curl('POST', 'rect', $parameters);

        return $result['value'];
    }

    /**
     * Get window handle: /session/:sessionId/window (GET)
     * - $session->window($handle)->getHandle()
     * - $session->window()->getHandle()
     *
     * @return string
     */
    public function getHandle()
    {
        if (! $this->windowHandle) {
            $result = $this->curl('GET', '');

            $this->windowHandle = array_key_exists(self::WEB_WINDOW_ID, $result['value'])
                ? $result['value'][self::WEB_WINDOW_ID]
                : $result['value'];
        }

        return $this->windowHandle;
    }
}
