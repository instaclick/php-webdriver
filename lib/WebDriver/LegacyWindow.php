<?php

/**
 * @copyright 2011 Anthon Pang
 * @license Apache-2.0
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\LegacyWindow class
 *
 * @method void maximize() Maximize the window if not already maximized.
 * @method array getPosition() Get position of the window.
 * @method void postPosition($parameters) Change position of the window.
 * @method array getSize() Get size of the window.
 * @method void postSize($parameters) Change the size of the window.
 *
 * @deprecated Not supported by W3C WebDriver
 */
class LegacyWindow extends AbstractWebDriver
{
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
            // Legacy JSON Wire Protocol
            'maximize' => ['POST'],
            'position' => ['GET', 'POST'],
            'size'     => ['GET', 'POST'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function obsoleteMethods()
    {
        return [
            'restore' => ['POST'],
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

        if (! $windowHandle || $windowHandle === 'current') {
            $result = $this->curl('GET', '_handle');

            $windowHandle = $result['value'];
        }

        $this->windowHandle = $windowHandle;

        $this->url .= '/' . $windowHandle;
    }

    /**
     * Get window handle: /session/:sessionId/window_handle (GET)
     * - $session->window($handle)->getHandle()
     * - $session->window()->getHandle()
     *
     * @return string
     */
    public function getHandle()
    {
        return $this->windowHandle;
    }
}
