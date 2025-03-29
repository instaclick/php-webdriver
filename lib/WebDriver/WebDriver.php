<?php

/**
 * @copyright 2004 Meta Platforms, Inc.
 * @license Apache-2.0
 *
 * @author Justin Bishop <jubishop@gmail.com>
 */

namespace WebDriver;

/**
 * WebDriver class
 *
 * W3C
 * @method array status() Returns information about whether a remote end is in a state in which it can create new sessions.
 * Selenium
 * @method array logs() Returns session logs mapped to session IDs.
 */
class WebDriver extends AbstractWebDriver implements WebDriverInterface
{
    /**
     * @var array
     */
    private $capabilities;

    /**
     * @var array
     */
    static $w3cCapabilities = [
        Capability::ACCEPT_INSECURE_CERTS => 1,
        Capability::BROWSER_NAME => 1,
        Capability::BROWSER_VERSION => 1,
        Capability::PAGE_LOAD_STRATEGY => 1,
        Capability::PLATFORM_NAME => 1,
        Capability::PROXY => 1,
        Capability::SET_WINDOW_RECT => 1,
        Capability::STRICT_FILE_INTERACTABILITY => 1,
        Capability::TIMEOUTS => 1,
        Capability::UNHANDLED_PROMPT_BEHAVIOR => 1,
        Capability::USER_AGENT => 1,
    ];

    /**
     * @var array
     */
    static $w3cToLegacy = [
        Capability::PLATFORM_NAME         => Capability::PLATFORM,
        Capability::BROWSER_VERSION       => Capability::VERSION,
        Capability::ACCEPT_INSECURE_CERTS => Capability::ACCEPT_SSL_CERTS,
    ];

    /**
     * @var array|null
     */
    static $legacyToW3c = [
        Capability::PLATFORM         => Capability::PLATFORM_NAME,
        Capability::VERSION          => Capability::BROWSER_VERSION,
        Capability::ACCEPT_SSL_CERTS => Capability::ACCEPT_INSECURE_CERTS,
    ];

    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return [
            'status' => ['GET'],

            // Selenium
            'logs'   => ['POST'],
        ];
    }

    /**
     * Constructor
     *
     * @param string $url
     */
    public function __construct($url)
    {
        parent::__construct($url);
    }

    /**
     * {@inheritdoc}
     */
    public function session($browserName = Browser::FIREFOX, $desiredCapabilities = null, $requiredCapabilities = null)
    {
        // default to W3C WebDriver API
        $capabilities = is_array($desiredCapabilities) ? $this->filter($this->remap(self::$legacyToW3c, $desiredCapabilities)) : null;
        $firstMatch = $capabilities ? [$capabilities] : [];
        $firstMatch[] = [Capability::BROWSER_NAME => Browser::CHROME];

        if ($browserName !== Browser::CHROME) {
            $firstMatch[] = [Capability::BROWSER_NAME => $browserName];
        }

        $parameters = ['capabilities' => ['firstMatch' => $firstMatch]];

        if (is_array($requiredCapabilities) && count($requiredCapabilities)) {
            $parameters['capabilities']['alwaysMatch'] = $this->filter($this->remap(self::$legacyToW3c, $requiredCapabilities));
        }

        try {
            $result = $this->curl(
                'POST',
                '/session',
                $parameters,
                [CURLOPT_FOLLOWLOCATION => true]
            );
        } catch (\Exception $e) {
            // fallback to legacy JSON Wire Protocol
            $capabilities = $desiredCapabilities ?: [];
            $capabilities[Capability::BROWSER_NAME] = $browserName;

            $parameters = ['desiredCapabilities' => $this->remap(self::$w3cToLegacy, $capabilities)];

            if (is_array($requiredCapabilities) && count($requiredCapabilities)) {
                $parameters['requiredCapabilities'] = $this->remap(self::$w3cToLegacy, $requiredCapabilities);
            }

            $result = $this->curl(
                'POST',
                '/session',
                $parameters,
                [CURLOPT_FOLLOWLOCATION => true]
            );
        }

        $this->capabilities = $result['value']['capabilities'] ?? null;

        $session = new Session($result['sessionUrl'], $this->capabilities);

        return $session;
    }

    /**
     * Get Sessions: /sessions (GET)
     * Get list of currently active sessions
     *
     * @deprecated
     *
     * @return array an array of \WebDriver\Session objects
     */
    public function sessions()
    {
        $result = $this->curl('GET', '/sessions');
        $sessions = [];

        foreach ($result['value'] as $session) {
            $session = new Session($this->url . '/session/' . $session['id'], $this->capabilities);

            $sessions[] = $session;
        }

        return $sessions;
    }

    /**
     * Filter capabilities
     *
     * @param array $capabilities
     *
     * @return array
     */
    private function filter($capabilities)
    {
        return $capabilities ? array_values(array_filter($capabilities, function ($capability) { return self::$w3cCapabilities[$capability] ?? 0; })) : null;
    }

    /**
     * Remap capabilities
     *
     * @param array $mapping
     * @param array $capabilities
     *
     * @return array
     */
    private function remap($mapping, $capabilities)
    {
        $new = [];

        foreach ($capabilities as $key => $value) {
            if (array_key_exists($key, $mapping)) {
                $key = $mapping[$key];
            }

            $new[$key] = $value;
        }

        return $new;
    }
}
