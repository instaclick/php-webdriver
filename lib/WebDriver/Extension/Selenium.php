<?php

/**
 * @copyright 2023 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver\Extension;

use WebDriver\AbstractWebDriver;

/**
 * Selenium extensions
 *
 * {@internal
 *     /se/files Downloads requires se:downloadsEnabled
 * }}
 *
 * @package WebDriver
 */
class Selenium extends AbstractWebDriver
{
    /**
     * Get log: /session/:sessionId/se/log
     *
     * @param mixed $parameters
     *
     * @return mixed
     */
    public function getLog($parameters)
    {
        if (is_string($parameters)) {
            $parameters = [
                'type' => $parameters,
            ];
        }

        $result = $this->curl('POST', '/log', $parameters);

        return $result['value'];
    }

    /**
     * Get available log types: /session/:sessionId/se/log/types
     *
     * @return mixed
     */
    public function getAvailableLogTypes()
    {
        $result = $this->curl('GET', '/log/types');

        return $result['value'];
    }

    /**
     * Download File: /session/:sessionId/se/files (POST)
     *
     * @param array|string $parameters Parameters {'name': ...}
     *
     * @eturn mixed
     */
    public function downloadFile($parameters)
    {
        if (is_string($parameters)) {
            $parameters = ['name' => $parameters];
        }

        $result = $this->curl('POST', '/se/files', $parameters);

        return $result['value'];
    }

    /**
     * Get Downloadable Files: /session/:sessionId/se/files (GET)
     *
     * @eturn mixed
     */
    public function getDownloadableFiles()
    {
        $result = $this->curl('GET', '/se/files');

        return $result['value'];
    }

    /**
     * Delete Downloadable Files: /session/:sessionId/se/files (DELETE)
     *
     * @eturn mixed
     */
    public function deleteDownloadableFiles()
    {
        $result = $this->curl('DELETE', '/se/files');

        return $result['value'];
    }

    /**
     * Upload File: /session/:sessionId/se/file (POST)
     *
     * @param array|string $parameters Parameters {file: ...}
     *
     * @eturn mixed
     */
    public function uploadFile($parameters)
    {
        if (is_string($parameters)) {
            $parameters = ['file' => $parameters];
        }

        // expecting ZIP file format
        if (substr($parameters['file'], 0, 4) === "PK\x03\x04") {
            $parameters['file'] = base64_encode($parameters['file']);
        } elseif (substr($parameters['file'], 0, 5) !== 'UEsDB') {
            // suspicious but looks intentional
            trigger_error('UPLOAD_FILE expected base64 encoded ZIP file', E_USER_NOTICE);
        }

        $result = $this->curl('POST', '/se/file', $parameters);

        return $result['value'];
    }
}
