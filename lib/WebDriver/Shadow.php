<?php

/**
 * Copyright 2021-2022 Anthon Pang. All Rights Reserved.
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
 * WebDriver\Shadow class
 *
 * @package WebDriver
 *
 * @deprecated by W3C WebDriver
 */
final class Shadow extends Container
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
    protected function getElementPath($elementId)
    {
        return sprintf('%s/element/%s', $this->url, $elementId);
    }
}
