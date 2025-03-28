<?php

/**
 * @copyright 2014 Anthon Pang
 * @license Apache-2.0
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\Log class
 *
 * @method array types() Get available log types.
 *
 * @deprecated Not supported by W3C WebDriver
 */
class Log extends AbstractWebDriver
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return [
            'types' => ['GET'],
        ];
    }
}
