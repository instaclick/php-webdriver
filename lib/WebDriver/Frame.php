<?php

/**
 * @copyright 2014 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\Frame class
 *
 * @package WebDriver
 *
 * @method void parent() Change focus to the parent context.
 */
class Frame extends AbstractWebDriver
{
    const WEB_FRAME_ID = 'frame-075b-4da1-b6ba-e579c2d3230a';

    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return array(
            'parent' => array('POST'),
        );
    }
}
