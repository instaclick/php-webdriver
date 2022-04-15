<?php

/**
 * @copyright 2017 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\Alert class
 *
 * @package WebDriver
 *
 * @method array accept() Accept Alert
 * @method array dismiss() Dismiss Alert
 * @method array getText() Get Alert Text
 * @method array postText() Send Alert Text
 */
class Alert extends AbstractWebDriver
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return array(
            'accept' => array('POST'),
            'dismiss' => array('POST'),
            'text' => array('GET', 'POST'),
        );
    }
}
