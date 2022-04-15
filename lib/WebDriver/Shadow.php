<?php

/**
 * @copyright 2021 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\Shadow class
 *
 * @package WebDriver
 *
 * @deprecated by W3C WebDriver
 */
class Shadow extends Container
{
    const SHADOW_ROOT_ID = 'shadow-6066-11e4-a52e-4f735466cecf';

    /**
     * Shadow ID
     *
     * @var string
     */
    private $id;

    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return array();
    }

    /**
     * Constructor
     *
     * @param string $url URL
     * @param string $id  shadow ID
     */
    public function __construct($url, $id)
    {
        parent::__construct($url);

        $this->id = $id;
    }

    /**
     * Get shadow ID
     *
     * @return string
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    protected function getIdentifierPath($identifier)
    {
        return sprintf('%s/element/%s', $this->url, $identifier);
    }
}
