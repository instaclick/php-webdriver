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
 * WebDriver\KeyInput class
 *
 * @package WebDriver
 */
class KeyInput extends NullInput
{
    const TYPE = 'key';

    // actions
    const KEY_DOWN = 'keyDown';
    const KEY_UP   = 'keyUp';

    /**
     * Key Down
     *
     * {@internal action item properties:
     *     value: string - mandatory; contains a single unicode code point
     * }}
     *
     * @param array $action Action item
     *
     * @return array
     */
    public function keyDown($action)
    {
        $action['type'] = self::KEY_DOWN;

        return [
            'id'      => $this->id,
            'type'    => static::TYPE,
            'actions' => [
                $action,
            ],
        ];
    }

    /**
     * Key Up
     *
     * {@internal action item properties:
     *     value: string - mandatory; contains a single unicode code point
     * }}
     *
     * @param array $action Action item
     *
     * @return array
     */
    public function keyUp($action)
    {
        $action['type'] = self::KEY_UP;

        return [
            'id'      => $this->id,
            'type'    => static::TYPE,
            'actions' => [
                $action,
            ],
        ];
    }
}
