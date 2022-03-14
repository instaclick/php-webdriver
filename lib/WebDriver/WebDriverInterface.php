<?php

/**
 * Copyright 2004-2022 Facebook. All Rights Reserved.
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
 * @author Justin Bishop <jubishop@gmail.com>
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriverInterface interface
 *
 * @package WebDriver
 */
interface WebDriverInterface
{
    /**
     * New Session: /session (POST)
     * Get session object for chaining
     *
     * @param string $browserName          Preferred browser
     * @param array  $desiredCapabilities  Optional desired capabilities
     * @param array  $requiredCapabilities Optional required capabilities
     *
     * @return \WebDriver\Session
     */
    public function session($browserName = Browser::FIREFOX, $desiredCapabilities = null, $requiredCapabilities = null);
}
