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
 * WebDriver\Log class
 *
 * @package WebDriver
 *
 * @method array types() Get available log types.
 */
class Log extends AbstractWebDriver
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return array(
            'types' => array('GET'),
        );
    }
}
