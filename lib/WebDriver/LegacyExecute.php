<?php

/**
 * Copyright 2022-2022 Anthon Pang. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
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
    protected function getElementPath($identifier)
    {
        return $this->url . $identifier;
    }
}
