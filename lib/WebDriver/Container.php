<?php

/**
 * @copyright 2004 Meta Platforms, Inc.
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Justin Bishop <jubishop@gmail.com>
 */

namespace WebDriver;

use WebDriver\Exception as WebDriverException;

/**
 * Abstract WebDriver\Container class
 *
 * @package WebDriver
 */
abstract class Container extends AbstractWebDriver
{
    /**
     * @var array
     */
    private $strategies;

    /**
     * {@inheritdoc}
     */
    public function __construct($url)
    {
        parent::__construct($url);

        $locatorStrategy = new \ReflectionClass('WebDriver\LocatorStrategy');

        $this->strategies = $locatorStrategy->getConstants();
    }

    /**
     * Find element: /session/:sessionId/element (POST)
     * Find child element: /session/:sessionId/element/:id/element (POST)
     * Search for element on page, starting from the document root.
     *
     * @param string $using the locator strategy to use
     * @param string $value the search target
     *
     * @return \WebDriver\Element
     *
     * @throws \WebDriver\Exception if element not found, or invalid XPath
     */
    public function element($using = null, $value = null)
    {
        $locatorJson = $this->parseArgs('element', func_get_args());

        try {
            $result = $this->curl(
                'POST',
                '/element',
                $locatorJson
            );
        } catch (WebDriverException\NoSuchElement $e) {
            throw WebDriverException::factory(
                WebDriverException::NO_SUCH_ELEMENT,
                sprintf(
                    "Element not found with %s, %s\n\n%s",
                    $locatorJson['using'],
                    $locatorJson['value'],
                    $e->getMessage()
                ),
                $e
            );
        }

        $element = $this->makeElement($result['value']);

        if ($element === null) {
            throw WebDriverException::factory(
                WebDriverException::NO_SUCH_ELEMENT,
                sprintf(
                    "Element not found with %s, %s\n",
                    $locatorJson['using'],
                    $locatorJson['value']
                )
            );
        }

        return $element;
    }

    /**
     * Find elements: /session/:sessionId/elements (POST)
     * Find child elements: /session/:sessionId/element/:id/elements (POST)
     * Search for multiple elements on page, starting from the document root.
     *
     * @param string $using the locator strategy to use
     * @param string $value the search target
     *
     * @return array
     *
     * @throws \WebDriver\Exception if invalid XPath
     */
    public function elements($using = null, $value = null)
    {
        $locatorJson = $this->parseArgs('elements', func_get_args());

        $result = $this->curl(
            'POST',
            '/elements',
            $locatorJson
        );

        if (! is_array($result['value'])) {
            return array();
        }

        return array_filter(
            array_map(
                array($this, 'makeElement'),
                $result['value']
            )
        );
    }

    /**
     * Parse arguments allowing either separate $using and $value parameters, or
     * as an array containing the JSON parameters
     *
     * @param string $method method name
     * @param array  $argv   arguments
     *
     * @return array
     *
     * @throws \WebDriver\Exception if invalid number of arguments to the called method
     */
    private function parseArgs($method, $argv)
    {
        $argc = count($argv);

        switch ($argc) {
            case 2:
                $using = $argv[0];
                $value = $argv[1];
                break;

            case 1:
                $arg = $argv[0];

                if (is_array($arg)) {
                    $using = $arg['using'];
                    $value = $arg['value'];
                    break;
                }

                // fall through
            default:
                throw WebDriverException::factory(
                    WebDriverException::JSON_PARAMETERS_EXPECTED,
                    sprintf('Invalid arguments to %s method: %s', $method, print_r($argv, true))
                );
        }

        return $this->locate($using, $value);
    }

    /**
     * Return JSON parameter for element / elements command
     *
     * @param string $using locator strategy
     * @param string $value search target
     *
     * @return array
     *
     * @throws \WebDriver\Exception if invalid locator strategy
     */
    public function locate($using, $value)
    {
        if (! in_array($using, $this->strategies)) {
            throw WebDriverException::factory(
                WebDriverException::UNKNOWN_LOCATOR_STRATEGY,
                sprintf('Invalid locator strategy %s', $using)
            );
        }

        return array(
            'using' => $using,
            'value' => $value,
        );
    }

    /**
     * Factory method for elements
     *
     * @param mixed $value
     *
     * @return \WebDriver\Element|null
     */
    protected function makeElement($value)
    {
        if (array_key_exists(LegacyElement::LEGACY_ELEMENT_ID, (array) $value)) {
            $identifier = $value[LegacyElement::LEGACY_ELEMENT_ID];

            return new LegacyElement(
                $this->getIdentifierPath($identifier),
                $identifier
            );
        }

        if (array_key_exists(Element::WEB_ELEMENT_ID, (array) $value)) {
            $identifier = $value[Element::WEB_ELEMENT_ID];

            return new Element(
                $this->getIdentifierPath($identifier),
                $identifier
            );
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function __call($name, $arguments)
    {
        if (count($arguments) === 1 && in_array(str_replace('_', ' ', $name), $this->strategies)) {
            return $this->locate($name, $arguments[0]);
        }

        // fallback to executing WebDriver commands
        return parent::__call($name, $arguments);
    }

    /**
     * Get wire protocol URL for an identifier
     *
     * @param string $identifier
     *
     * @return string
     */
    abstract protected function getIdentifierPath($identifier);
}
