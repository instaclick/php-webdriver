<?php

/**
 * @copyright 2025 Anthon Pang
 * @license Apache-2.0
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\PointerInput class
 */
class PointerInput extends NullInput
{
    const TYPE = 'pointer';

    // sub-types
    const MOUSE = 'mouse';
    const PEN   = 'pen';
    const TOUCH = 'touch';

    // actions
    const POINTER_DOWN   = 'pointerDown';
    const POINTER_UP     = 'pointerUp';
    const POINTER_MOVE   = 'pointerMove';
    const POINTER_CANCEL = 'pointerCancel';

    // buttons
    const LEFT_BUTTON    = 0;
    const MIDDLE_BUTTON  = 1;
    const RIGHT_BUTTON   = 2;
    const X1_BUTTON      = 3;
    const BACK_BUTTON    = 3;
    const X2_BUTTON      = 4;
    const FORWARD_BUTTON = 4;

    /**
     * @var string
     */
    private $subType;

    /**
     * @param integer $id
     * @param string  $subType
     */
    public function __construct($id, $subType)
    {
        parent::__construct($id);

        $this->subType = $subType;
    }

    /**
     * Pointer Down
     *
     * {@internal action item properties:
     *   button: int (0..) - mandatory
     *   height: number (0..)
     *   width: number (0..)
     *   pressure: float (0..1)
     *   tangentialPressure: float (-1..1)
     *   tiltX: int (-90..90)
     *   tiltY: int (-90..90)
     *   twist: int (0..359)
     *   altitudeAngle: float (0..pi/2)
     *   azimuthAngle: float (0..2pi)
     * }
     *
     * @param array $action Action item
     *
     * @return array
     */
    public function pointerDown($action)
    {
        $action['type'] = self::POINTER_DOWN;

        return [
            'id'      => $this->id,
            'type'    => static::TYPE,
            'actions' => [
                $action,
            ],
            'parameters' => [
                'pointerType' => $this->subType,
            ],
        ];
    }

    /**
     * Pointer Up
     *
     * {@internal action item properties:
     *   button: int (0..) - mandatory
     *   height: number (0..)
     *   width: number (0..)
     *   pressure: float (0..1)
     *   tangentialPressure: float (-1..1)
     *   tiltX: int (-90..90)
     *   tiltY: int (-90..90)
     *   twist: int (0..359)
     *   altitudeAngle: float (0..pi/2)
     *   azimuthAngle: float (0..2pi)
     * }
     *
     * @param array $action Action item
     *
     * @return array
     */
    public function pointerUp($action)
    {
        $action['type'] = self::POINTER_UP;

        return [
            'id'      => $this->id,
            'type'    => static::TYPE,
            'actions' => [
                $action
            ],
            'parameters' => [
                'pointerType' => $this->subType,
            ],
        ];
    }

    /**
     * Pointer Move
     *
     * {@internal action item properties:
     *   x: int (mandatory)
     *   y: int (mandatory)
     *   height: number (0..)
     *   width: number (0..)
     *   pressure: float (0..1)
     *   tangentialPressure: float (-1..1)
     *   tiltX: int (-90..90)
     *   tiltY: int (-90..90)
     *   twist: int (0..359)
     *   altitudeAngle: float (0..pi/2)
     *   azimuthAngle: float (0..2pi)
     *   duration: int (0..)
     *   origin: string
     * }
     *
     * @param array $action Action item
     *
     * @return array
     */
    public function pointerMove($action)
    {
        $action['type'] = self::POINTER_MOVE;

        return [
            'id'      => $this->id,
            'type'    => static::TYPE,
            'actions' => [
                $action,
            ],
            'parameters' => [
                'pointerType' => $this->subType,
            ],
        ];
    }

    /**
     * Pointer Cancel
     *
     * @param array $action Action item
     *
     * @return array
     */
    public function pointerCancel($action)
    {
        $action['type'] = self::POINTER_CANCEL;

        return [
            'id'      => $this->id,
            'type'    => static::TYPE,
            'actions' => [
                $action,
            ],
            'parameters' => [
                'pointerType' => $this->subType,
            ],
        ];
    }
}
