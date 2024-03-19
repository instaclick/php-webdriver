<?php

/**
 * @copyright 2017 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\Execute class
 *
 * @package WebDriver
 */
class Execute extends AbstractWebDriver
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return array();
    }

    /**
     * Inject a snippet of JavaScript into the page for execution in the context of the currently selected frame. (asynchronous)
     *
     * @param array{script: string, args: array} $jsonScript
     *
     * @return mixed
     */
    public function async(array $jsonScript)
    {
        $jsonScript['args'] = $this->serializeArguments($jsonScript['args']);

        $result = $this->curl('POST', '/async', $jsonScript);

        return $this->unserializeResult($result['value']);
    }

    /**
     * Inject a snippet of JavaScript into the page for execution in the context of the currently selected frame. (synchronous)
     *
     * @param array{script: string, args: array} $jsonScript
     *
     * @return mixed
     */
    public function sync(array $jsonScript)
    {
        $jsonScript['args'] = $this->serializeArguments($jsonScript['args']);

        $result = $this->curl('POST', '/sync', $jsonScript);

        return $this->unserializeResult($result['value']);
    }

    /**
     * {@inheritdoc}
     */
    protected function getIdentifierPath($identifier)
    {
        return preg_replace('~/execute$~', '', $this->url) . $identifier; // remove /execute from path
    }
}
