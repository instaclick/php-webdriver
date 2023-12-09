<?php

/**
 * @copyright 2017 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\Alert class
 *
 * @package WebDriver
 *
 * W3C
 * @method array accept() Accept alert.
 * @method array dismiss() Dismiss alert.
 * @method array getText() Get alert text.
 * @method array postText($parameters) Set alert value.
 * Selenium
 * @method array credentials($parameters) Set alert credentials.
 */
class Alert extends AbstractWebDriver
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return [
            'accept'      => ['POST'],
            'dismiss'     => ['POST'],
            'text'        => ['GET', 'POST'],

            // @deprecated
            'credentials' => ['POST'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return [
            // @deprecated
            'setAlertCredentials' => 'credentials',
        ];
    }

    /**
     * Accept alert: /session/:sessionId/alert/accept (POST)
     *
     * @return mixed
     */
    public function acceptAlert()
    {
        $result = $this->curl('POST', 'accept');

        return $result['value'];
    }

    /**
     * Dismiss alert: /session/:sessionId/alert/dismiss (POST)
     *
     * @return mixed
     */
    public function dismissAlert()
    {
        $result = $this->curl('POST', 'dismiss');

        return $result['value'];
    }

    /**
     * Get alert text: /session/:sessionId/alert/text (GET)
     *
     * @return mixed
     */
    public function getAlertText()
    {
        $result = $this->curl('GET', 'text');

        return $result['value'];
    }

    /**
     * Set alert value: /session/:sessionId/alert/text (POST)
     *
     * @param array|string $text Parameters {text: ...}
     *
     * @return mixed
     */
    public function setAlertValue($text)
    {
        $parameters = is_array($text)
            ? $text
            : ['text' => $text];

        $result = $this->curl('POST', 'text', $parameters);

        return $result['value'];
    }
}
