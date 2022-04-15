<?php

/**
 * @copyright 2011 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver\Storage;

use WebDriver\AbstractWebDriver;
use WebDriver\Exception as WebDriverException;

/**
 * WebDriver\AbstractStorage class
 *
 * @package WebDriver
 *
 * @method mixed getKey($key) Get key/value pair.
 * @method void deleteKey($key) Delete a specific key.
 * @method integer size() Get the number of items in the storage.
 */
abstract class AbstractStorage extends AbstractWebDriver
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return array(
            'key' => array('GET', 'DELETE'),
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
        if (func_num_args() === 0) {
            $result = $this->curl('GET', '');

            return $result['value'];
        }

        // get key/value pair
        if (func_num_args() === 1) {
            return $this->getKey(func_get_arg(0));
        }

        throw WebDriverException::factory(WebDriverException::UNEXPECTED_PARAMETERS);
    }

    /**
     * Set specific key/value pair
     *
     * @return \WebDriver\Storage\AbstractStorage
     *
     * @throw \WebDriver\Exception\UnexpectedParameters if unexpected parameters
     */
    public function set()
    {
        if (func_num_args() === 1 && is_array($arg = func_get_arg(0))) {
            $this->curl('POST', '', $arg);

            return $this;
        }

        if (func_num_args() === 2) {
            $arg = array(
                'key' => func_get_arg(0),
                'value' => func_get_arg(1),
            );
            $this->curl('POST', '', $arg);

            return $this;
        }

        throw WebDriverException::factory(WebDriverException::UNEXPECTED_PARAMETERS);
    }

    /**
     * Delete storage or a specific key
     *
     * @return \WebDriver\Storage\AbstractStorage
     *
     * @throw \WebDriver\Exception\UnexpectedParameters if unexpected parameters
     */
    public function delete()
    {
        // delete storage
        if (func_num_args() === 0) {
            $this->curl('DELETE', '');

            return $this;
        }

        // delete key from storage
        if (func_num_args() === 1) {
            $this->deleteKey(func_get_arg(0));

            return $this;
        }

        throw WebDriverException::factory(WebDriverException::UNEXPECTED_PARAMETERS);
    }
}
