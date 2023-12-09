<?php

/**
 * @copyright 2023 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver\Service;

use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * WebDriver\Service\VoidDispatcher class
 *
 * @internal A black hole for events.
 *
 * @package WebDriver
 */
class VoidDispatcher implements EventDispatcherInterface
{
    /**
     * {@inheritdoc}
     */
    public function dispatch(object $event)
    {
        return (object) [];
    }
}
