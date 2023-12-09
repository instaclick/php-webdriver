<?php

/**
 * @copyright 2023 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\WheelInput class
 *
 * @package WebDriver
 */
class WheelInput extends NullInput
{
    const TYPE = 'wheel';

    // actions
    const SCROLL = 'scroll';

    /**
     * Scroll
     *
     * {@internal action item properties:
     *     x: int - mandatory
     *     y: int - mandatory
     *     deltaX: int - mandatory
     *     deltaY: int - mandatory
     *     duration: int
     *     origin: string
     * }}
     *
     * @param array $action Action item
     *
     * @return array
     */
    public function scroll($action)
    {
        $action = [
            'type' => self::SCROLL,
        ];

        return [
            'id'      => $this->id,
            'type'    => static::TYPE,
            'actions' => [
                $action,
            ],
        ];
    }
}
