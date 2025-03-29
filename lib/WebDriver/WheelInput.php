<?php

/**
 * @copyright 2025 Anthon Pang
 * @license Apache-2.0
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\WheelInput class
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
     * }
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
