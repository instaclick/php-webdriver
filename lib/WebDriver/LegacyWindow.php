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
        return array();
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
        parent::__construct($url);

        $this->windowHandle = $windowHandle ?: 'current';
    }

    /**
     * Maximize the window if not already maximized: /session/:sessionId/window/:windowHandle/maximize (POST)
     */
    public function maximize()
    {
        $this->curl('POST', "/{$this->windowHandle}/maximize");
    }

    /**
     * Get position of the window: /session/:sessionId/window/:windowHandle/position (GET)
     *
     * @return array
     */
    public function getPosition()
    {
        $result = $this->curl('GET', "/{$this->windowHandle}/position");

        return $result['value'];
    }

    /**
     * Change position of the window: /session/:sessionId/window/:windowHandle/position (POST)
     *
     * @param array $json
     */
    public function postPosition(array $json)
    {
        $this->curl('POST', "/{$this->windowHandle}/position", $json);
    }

    /**
     * Get size of the window: /session/:sessionId/window/:windowHandle/size (GET)
     *
     * @return array
     */
    public function getSize()
    {
        $result = $this->curl('GET', "/{$this->windowHandle}/size");

        return $result['value'];
    }

    /**
     * Change the size of the window: /session/:sessionId/window/:windowHandle/size (POST)
     *
     * @param array $json
     */
    public function postSize(array $json)
    {
        $this->curl('POST', "/{$this->windowHandle}/size", $json);
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
        if (! $this->windowHandle || $this->windowHandle === 'current') {
            $result = $this->curl('GET', '_handle');

            $this->windowHandle = $result['value'];
        }

        return $this->windowHandle;
    }
}
