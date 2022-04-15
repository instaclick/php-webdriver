<?php

/**
 * Copyright 2017-2022 Anthon Pang. All Rights Reserved.
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
 * WebDriver\Execute class
 *
 * @package WebDriver
 */
final class Execute extends AbstractWebDriver
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
     * Serialize script arguments (containing web elements and/or shadow roots)
     *
     * @see https://w3c.github.io/webdriver/#executing-script
     *
     * @param array $arguments
     *
     * @return array
     */
    private function serializeArguments(array $arguments)
    {
        foreach ($arguments as $key => $value) {
            switch (true) {
                case $value instanceof LegacyElement:
                    $arguments[$key] = [LegacyElement::LEGACY_ELEMENT_ID => $value->getID()];
                    break;

                case $value instanceof Element:
                    $arguments[$key] = [Element::WEB_ELEMENT_ID => $value->getID()];
                    break;

                case $value instanceof Shadow:
                    $arguments[$key] = [Shadow::SHADOW_ROOT_ID => $value->getID()];
                    break;

                case is_array($value):
                    $arguments[$key] = $this->serializeArguments($value);
                    break;
            }
        }

        return $arguments;
    }

    /**
     * Unserialize result (containing web elements and/or shadow roots)
     *
     * @param mixed $result
     *
     * @return mixed
     */
    private function unserializeResult($result)
    {
        $element = is_array($result) ? $this->webDriverElement($result) : null;

        if ($element !== null) {
            return $element;
        }

        if (is_array($result)) {
            foreach ($result as $key => $value) {
                $result[$key] = $this->unserializeResult($value);
            }
        }

        return $result;
    }

    /**
     * Return WebDriver\Element wrapper for $value
     *
     * @param array $value
     *
     * @return \WebDriver\Element|\WebDriver\Shadow|null
     */
    protected function webDriverElement($value)
    {
        $basePath = preg_replace('~/execute$~', '', $this->url);

        if (array_key_exists(LegacyElement::LEGACY_ELEMENT_ID, $value)) {
            return new LegacyElement(
                $basePath . '/element/' . $value[LegacyElement::LEGACY_ELEMENT_ID], // url
                $value[LegacyElement::LEGACY_ELEMENT_ID], // id
                $this->legacy
            );
        }

        if (array_key_exists(Element::WEB_ELEMENT_ID, $value)) {
            return new Element(
                $basePath . '/element/' . $value[Element::WEB_ELEMENT_ID], // url
                $value[Element::WEB_ELEMENT_ID], // id
                $this->legacy
            );
        }

        if (array_key_exists(Shadow::SHADOW_ROOT_ID, $value)) {
            return new Shadow(
                $basePath . '/shadow/' . $value[Shadow::SHADOW_ROOT_ID], // url
                $value[Shadow::SHADOW_ROOT_ID], // id
                $this->legacy
            );
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    protected function getElementPath($unused)
    {
        return $this->url;
    }
}
