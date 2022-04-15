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
 * @method array accept() Accept alert.
 * @method array dismiss() Dismiss alert.
 * @method array getText() Get alert text.
 * @method array postText() Send alert text.
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
