<?php
/**
 * Copyright 2011-2012 Anthon Pang. All Rights Reserved.
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
 * @author Anthon Pang <anthonp@nationalfibre.net>
 */

/**
 * WebDriver_Storage class
 *
 * @package WebDriver
 *
 * @method key
 * @method size
 */
abstract class WebDriver_Storage extends WebDriver_Base
{
    const LOCAL = "Local";
    const SESSION = "Session";

    /**
     * Return array of supported method names and corresponding HTTP request types
     *
     * @return array
     */
    protected function methods()
    {
        return array(
            'key' => array('GET'),
            'size' => array('GET'),
        );
    }

    /**
     * Get all keys from storage or a specific key/value pair
     *
     * @return mixed
     */
    public function get()
    {
        // get all keys
        if (func_num_args() == 0) {
            $result = $this->curl('GET', '');

            return $result['value'];
        }

        // get key/value pair
        if (func_num_args() == 1) {
            $arg = func_get_arg(0);
            $this->curl('GET', '/key/' . $arg);

            return $this;
        }

        throw WebDriver_Exception::factory(WebDriver_Exception::UNEXPECTED_PARAMETERS);
    }

    /**
     * Set specific key/value pair
     *
     * @return WebDriver_Base
     */
    public function set()
    {
        if (func_num_args() == 1
            && is_array($arg = func_get_arg(0))
        ) {
            $this->curl('POST', '', $arg);

            return $this;
        }

        if (func_num_args() == 2) {
            $arg = array(
                'key' => func_get_arg(0),
                'value' => func_get_arg(1),
            );
            $this->curl('POST', '', $arg);

            return $this;
        }

        throw WebDriver_Exception::factory(WebDriver_Exception::UNEXPECTED_PARAMETERS);
    }

    /**
     * Delete storage or a specific key
     *
     * @return WebDriver_Base
     */
    public function delete()
    {
        // delete storage
        if (func_num_args() == 0) {
            $this->curl('DELETE', '/delete');

            return $this;
        }

        // delete key from storage
        if (func_num_args() == 1) {
            $key = func_get_arg(0);
            $this->curl('DELETE', '/key/' . $key);

            return $this;
        }

        throw WebDriver_Exception::factory(WebDriver_Exception::UNEXPECTED_PARAMETERS);
    }

    /**
     * Factory method to create Storage objects
     *
     * @param string $type "local" or "session" storage
     * @param string $url  URL
     *
     * @return WebDriver_Storage
     */
    public static function factory($type, $url)
    {
        // dynamically define custom storage classes
        $className = __CLASS__ . '_' . $type;
        if (!class_exists($className, false)) {
            eval(
                'final class ' . $className.' extends WebDriver_Storage {}'
            );
        }

        return new $className($url);
    }
}
