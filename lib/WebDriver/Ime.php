<?php

/**
 * @copyright 2011 Anthon Pang
 * @license Apache-2.0
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\Ime class
 *
 * @method void activate($parameters) Make an engine that is available active.
 * @method boolean activated() Indicates whether IME input is active at the moment.
 * @method string active_engine() Get the name of the active IME engine.
 * @method array available_engines() List all available engines on the machines.
 * @method void deactivate() De-activates the currently active IME engine.
 *
 * @deprecated Not supported by W3C WebDriver
 */
class Ime extends AbstractWebDriver
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return [
            'activate'          => ['POST'],
            'activated'         => ['GET'],
            'active_engine'     => ['GET'],
            'available_engines' => ['GET'],
            'deactivate'        => ['POST'],
        ];
    }
}
