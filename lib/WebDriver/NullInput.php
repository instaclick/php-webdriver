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
 * WebDriver\NullInput class
 *
 * @package WebDriver
 */
class NullInput
{
    const TYPE = 'none';

    // actions
    const PAUSE = 'pause';

    /**
     * @var integer
     */
    protected $id;

    /**
     * @param integer $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Creates a pause of the given duration
     *
     * {@internal action item properties:
     *    duration: int
     * }}
     *
     * @param array $action Action item
     *
     * @return array
     */
    public function pause($action)
    {
        $action['type'] = self::PAUSE;

        return [
            'id'      => $this->id,
            'type'    => static::TYPE,
            'actions' => [
                $action,
            ],
        ];
    }
}
