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
 * WebDriver\LegacyWindow class
 *
 * @package WebDriver
 *
 * @method void maximize() Maximize the window if not already maximized.
 * @method array getPosition() Get position of the window.
 * @method void postPosition($json) Change position of the window.
 * @method array getSize() Get size of the window.
 * @method void postSize($json) Change the size of the window.
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
        return array(
            // Legacy JSON Wire Protocol
            'maximize' => array('POST'),
            'position' => array('GET', 'POST'),
            'size' => array('GET', 'POST'),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function obsoleteMethods()
    {
        return array(
            'restore' => array('POST'),
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
        parent::__construct($url . '/' . $windowHandle);

        $this->windowHandle = $windowHandle;
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
        if (! $this->windowHandle) {
            $result = $this->curl('GET', '_handle');

            $this->windowHandle = $result['value'];
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
