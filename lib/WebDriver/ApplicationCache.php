<?php

/**
 * @copyright 2012 Anthon Pang
 * @license Apache-2.0
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\ApplicationCache class
 *
 * @deprecated
 *
 * @method integer status() Get application cache status.
 */
class ApplicationCache extends AbstractWebDriver
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return [
            'status' => ['GET'],
        ];
    }
}
