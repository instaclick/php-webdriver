<?php

/**
 * @copyright 2022 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\LegacyExecute class
 *
 * @package WebDriver
 */
class LegacyExecute extends Execute
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

        $result = $this->curl('POST', '/execute_async', $jsonScript);

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

        $result = $this->curl('POST', '/execute', $jsonScript);

        return $this->unserializeResult($result['value']);
    }

    /**
     * {@inheritdoc}
     */
    protected function getIdentifierPath($identifier)
    {
        return $this->url . $identifier;
    }
}
