<?php
/**
 * Copyright 2004-2012 Facebook. All Rights Reserved.
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
 * @author Anthon Pang <anthonp@nationalfibre.net>
 */

/**
 * WebDriver_Environment class
 *
 * For security reasons some enterprises don't allow the use of some built-in
 * php functions.  This class is meant to be a proxy for these functions.
 * Modify these as necessary for your enviroment, and then .gitignore this file
 * so you can still easily git pull other changes from the main github repo.
 *
 * @package WebDriver
 */
final class WebDriver_Environment
{
    /**
     * Proxy method for curl_init()
     *
     * @param string $requestMethod HTTP request method, e.g., GET, POST, etc
     * @param string $url           URL
     * @param array  $params        Parameters
     *
     * @return resource curl handle
     */
    public static function CurlInit($requestMethod, $url, $params)
    {
        return curl_init($url);
    }

    /**
     * Proxy method for curl_exec()
     *
     * @param resource $ch curl handle
     *
     * @return boolean True if successful; false otherwise
     */
    public static function CurlExec($ch)
    {
        return curl_exec($ch);
    }
}
