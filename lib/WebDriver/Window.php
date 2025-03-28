<?php

/**
 * @copyright 2011 Anthon Pang
 * @license Apache-2.0
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\Window class
 *
 * @method array handles() Get window handles.
 * @method array fullscreen() Fullscreen window.
 * @method array maximize() Maximize the window if not already maximized.
 * @method array minimize() Minimize window.
 * @method array getRect() Get window rect.
 * @method array postRect($parameters) Set window rect.
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
            'handles'    => ['GET'],
            'fullscreen' => ['POST'],
            'maximize'   => ['POST'],
            'minimize'   => ['POST'],
            'rect'       => ['GET', 'POST'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function obsoleteMethods()
    {
        return [
            // Legacy JSON Wire Protocol
            'position' => ['GET', 'POST'],
            'size'     => ['GET', 'POST'],
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

            $this->windowHandle = is_array($result['value']) && array_key_exists(self::WEB_WINDOW_ID, $result['value'])
                ? $result['value'][self::WEB_WINDOW_ID]
                : $result['value'];
        }

        return $this->windowHandle;
    }
}
