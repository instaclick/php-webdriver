<?php

/**
 * @copyright 2011 Anthon Pang
 * @license Apache-2.0
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\Touch class
 *
 * @method void click($parameters) Single tap on the touch enabled device.
 * @method void doubleclick($parameters) Double tap on the touch screen using finger motion events.
 * @method void down($parameters) Finger down on the screen.
 * @method void flick($parameters) Flick on the touch screen using finger motion events.
 * @method void longclick($parameters) Long press on the touch screen using finger motion events.
 * @method void move($parameters) Finger move on the screen.
 * @method void scroll($parameters) Scroll on the touch screen using finger based motion events.  Coordinates are either absolute, or relative to a element (if specified).
 * @method void up($parameters) Finger up on the screen.
 *
 * @deprecated Not supported by W3C WebDriver
 */
class Touch extends AbstractWebDriver
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return [
            'click'       => ['POST'],
            'doubleclick' => ['POST'],
            'down'        => ['POST'],
            'flick'       => ['POST'],
            'longclick'   => ['POST'],
            'move'        => ['POST'],
            'scroll'      => ['POST'],
            'up'          => ['POST'],
        ];
    }
}
