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
 * WebDriver\Actions class
 *
 * @package WebDriver
 */
class Actions extends AbstractWebDriver
{
    /**
     * singleton
     *
     * @var \WebDriver\Actions
     */
    private static $instance;

    /**
     * @var array
     */
    private $inputSources = [
        NullInput::TYPE    => [],
        KeyInput::TYPE     => [],
        PointerInput::TYPE => [],
        WheelInput::TYPE   => [],
    ];

    /**
     * @var array
     */
    private $actions;

    /**
     * {@inheritDoc}
     */
    private function __construct($url)
    {
        parent::__construct($url);

        $this->clearAllActions();
    }

    /**
     * Get singleton instance
     *
     * @param string $url
     *
     * @return \WebDriver\Actions
     */
    public static function getInstance($url)
    {
        if (self::$instance === null) {
            self::$instance = new self($url);
        }

        return self::$instance;
    }

    /**
     * Get Null Input Source
     *
     * @return \WebDriver\NullInput
     */
    public function getNullInput($id = 0)
    {
        if (! array_key_exists($id, $this->inputSources[NullInput::TYPE])) {
            $inputSource = new NullInput($id);

            $this->inputSources[NullInput::TYPE][$id] = $inputSource;
        }

        return $this->inputSources[NullInput::TYPE][$id];
    }

    /**
     * Get Key Input Source
     *
     * @return \WebDriver\KeyInput
     */
    public function getKeyInput($id = 0)
    {
        if (! array_key_exists($id, $this->inputSources[KeyInput::TYPE])) {
            $inputSource = new KeyInput($id);

            $this->inputSources[KeyInput::TYPE][$id] = $inputSource;
        }

        return $this->inputSources[KeyInput::TYPE][$id];
    }

    /**
     * Get Pointer Input Source
     *
     * @return \WebDriver\PointerInput
     */
    public function getPointerInput($id = 0, $subType = PointerInput::MOUSE)
    {
        if (! array_key_exists($id, $this->inputSources[PointerInput::TYPE])) {
            $inputSource = new PointerInput($id, $subType);

            $this->inputSources[PointerInput::TYPE][$id] = $inputSource;
        }

        return $this->inputSources[PointerInput::TYPE][$id];
    }

    /**
     * Get Wheel Input Source
     *
     * @return \WebDriver\WheelInput
     */
    public function getWheelInput($id = 0)
    {
        if (! array_key_exists($id, $this->inputSources[WheelInput::TYPE])) {
            $inputSource = new WheelInput($id);

            $this->inputSources[WheelInput::TYPE][$id] = $inputSource;
        }

        return $this->inputSources[WheelInput::TYPE][$id];
    }

    /**
     * Perform actions: /session/:sessionId/actions (POST)
     *
     * @return mixed
     */
    public function perform()
    {
        $actions = $this->actions;
        $parameters = ['actions' => $actions];

        $this->clearAllActions();

        $result = $this->curl('POST', '', $parameters);

        return $result['value'];
    }

    /**
     * Release all action state: /session/:sessionId/actions (DELETE)
     *
     * @return mixed
     */
    public function releaseActions()
    {
        $result = $this->curl('DELETE', '');

        return $result['value'];
    }

    /**
     * Clear all actions from the builder
     */
    public function clearAllActions()
    {
        $this->actions = [];
    }

    /**
     * Add action
     *
     * @param array $action
     *
     * @return \WebDriver\Actions
     */
    public function addAction($action)
    {
        if (($last = count($this->actions)) &&
            $this->actions[$last - 1]['id'] === $action['id'] &&
            $this->actions[$last - 1]['type'] === $action['type']
        ) {
            foreach ($action['actions'] as $item) {
                $this->actions[$last - 1]['actions'][] = $item;
            }
        } else {
            $this->actions[] = $action;
        }

        return $this;
    }
}
