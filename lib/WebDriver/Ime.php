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
 * WebDriver\Ime class
 *
 * @package WebDriver
 *
 * @method void activate($json) Make an engine that is available active.
 * @method boolean activated() Indicates whether IME input is active at the moment.
 * @method string active_engine() Get the name of the active IME engine.
 * @method array available_engines() List all available engines on the machines.
 * @method void deactivate() De-activates the currently active IME engine.
 */
class Ime extends AbstractWebDriver
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return array(
            'activate' => array('POST'),
            'activated' => array('GET'),
            'active_engine' => array('GET'),
            'available_engines' => array('GET'),
            'deactivate' => array('POST'),
        );
    }
}
