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
     * Window handle
     *
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
     * Get window handle
     *
     * @return string
     */
    public function getHandle()
    {
        return $this->windowHandle;
    }

    /**
     * Constructor
     *
     * @param string $url          URL
     * @param string $windowHandle Window handle
     */
    public function __construct($url, $windowHandle)
    {
        $this->windowHandle = $windowHandle;

        parent::__construct($url . '/' . $windowHandle);
    }
}
