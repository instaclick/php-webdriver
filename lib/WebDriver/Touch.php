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
 * WebDriver\Touch class
 *
 * @package WebDriver
 *
 * @method void click($jsonElement) Single tap on the touch enabled device.
 * @method void doubleclick($jsonElement) Double tap on the touch screen using finger motion events.
 * @method void down($jsonCoordinates) Finger down on the screen.
 * @method void flick($json) Flick on the touch screen using finger motion events.
 * @method void longclick($jsonElement) Long press on the touch screen using finger motion events.
 * @method void move($jsonCoordinates) Finger move on the screen.
 * @method void scroll($jsonCoordinates) Scroll on the touch screen using finger based motion events.  Coordinates are either absolute, or relative to a element (if specified).
 * @method void up($jsonCoordinates) Finger up on the screen.
 */
class Touch extends AbstractWebDriver
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return array(
            'click' => array('POST'),
            'doubleclick' => array('POST'),
            'down' => array('POST'),
            'flick' => array('POST'),
            'longclick' => array('POST'),
            'move' => array('POST'),
            'scroll' => array('POST'),
            'up' => array('POST'),
        );
    }
}
