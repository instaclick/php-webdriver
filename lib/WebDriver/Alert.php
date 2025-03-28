<?php

/**
 * @copyright 2017 Anthon Pang
 * @license Apache-2.0
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\Alert class
 *
 * @method array accept() Accept alert.
 * @method array dismiss() Dismiss alert.
 * @method array getText() Get alert text.
 * @method array postText($parameters) Send alert text.
 */
class Alert extends AbstractWebDriver
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return [
            'accept'      => ['POST'],
            'dismiss'     => ['POST'],
            'text'        => ['GET', 'POST'],

            // Selenium
            'credentials' => ['POST'],
        ];
    }
}
