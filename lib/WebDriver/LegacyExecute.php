<?php

/**
 * @copyright 2022 Anthon Pang
 * @license Apache-2.0
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\LegacyExecute class
 *
 * @deprecated Not supported by W3C WebDriver
 */
class LegacyExecute extends Execute
{
    /**
     * Inject a snippet of JavaScript into the page for execution in the context of the currently selected frame. (asynchronous)
     *
     * @param array{script: string, args: array} $parameters
     *
     * @return mixed
     */
    public function async(array $parameters)
    {
        $parameters['args'] = $this->serializeArguments($parameters['args']);

        $result = $this->curl('POST', '/execute_async', $parameters);

        return $this->unserializeResult($result['value']);
    }

    /**
     * Inject a snippet of JavaScript into the page for execution in the context of the currently selected frame. (synchronous)
     *
     * @param array{script: string, args: array} $parameters
     *
     * @return mixed
     */
    public function sync(array $parameters)
    {
        $parameters['args'] = $this->serializeArguments($parameters['args']);

        $result = $this->curl('POST', '/execute', $parameters);

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
