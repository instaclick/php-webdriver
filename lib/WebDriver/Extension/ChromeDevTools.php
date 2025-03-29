<?php

/**
 * @copyright 2025 Anthon Pang
 * @license Apache-2.0
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver\Extension;

use WebDriver\AbstractWebDriver;

/**
 * Chrome Dev Tools extension
 *
 * @see https://chromedevtools.github.io/devtools-protocol/
 */
class ChromeDevTools extends AbstractWebDriver
{
    /**
     * Execute Command: /session/:sessionId/goog/cdp/execute (POST)
     *
     * @param array|string $cmd    Command or Parameters {'cmd': ..., 'params': ...}
     * @param mixed        $params Optional paramaters
     *
     * @return mixed
     */
    public function execute($cmd, $params = null)
    {
        $parameters = is_array($cmd)
            ? $cmd
            : ['cmd' => $cmd, 'params' => $params ?? (object)[]];

        $result = $this->curl('POST', '/execute', $parameters);

        return $result['value'];
    }
}
