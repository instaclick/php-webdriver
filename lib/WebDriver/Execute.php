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
 * WebDriver\Execute class
 *
 * @package WebDriver
 */
class Execute extends AbstractWebDriver
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

        $result = $this->curl('POST', '/async', $jsonScript);

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

        $result = $this->curl('POST', '/sync', $jsonScript);

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
    protected function serializeArguments(array $arguments)
    {
        foreach ($arguments as $key => $value) {
            if ($value instanceof LegacyElement) {
                $arguments[$key] = [LegacyElement::LEGACY_ELEMENT_ID => $value->getID()];
            } elseif ($value instanceof Element) {
                $arguments[$key] = [Element::WEB_ELEMENT_ID => $value->getID()];
            } elseif ($value instanceof Shadow) {
                $arguments[$key] = [Shadow::SHADOW_ROOT_ID => $value->getID()];
            } elseif (is_array($value)) {
                $arguments[$key] = $this->serializeArguments($value);
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
    protected function unserializeResult($result)
    {
        $element = is_array($result) ? $this->makeElement($result) : null;

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
     * Factory method for elements
     *
     * @param array $value
     *
     * @return \WebDriver\Element|\WebDriver\Shadow|null
     */
    protected function makeElement($value)
    {
        if (array_key_exists(LegacyElement::LEGACY_ELEMENT_ID, $value)) {
            $identifier = $value[LegacyElement::LEGACY_ELEMENT_ID];

            return new LegacyElement(
                $this->getIdentifierPath('/element/' . $identifier),
                $identifier
            );
        }

        if (array_key_exists(Element::WEB_ELEMENT_ID, $value)) {
            $identifier = $value[Element::WEB_ELEMENT_ID];

            return new Element(
                $this->getIdentifierPath('/element/' . $identifier),
                $identifier
            );
        }

        if (array_key_exists(Shadow::SHADOW_ROOT_ID, $value)) {
            $identifier = $value[Shadow::SHADOW_ROOT_ID];

            return new Shadow(
                $this->getIdentifierPath('/shadow/' . $identifier),
                $identifier
            );
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    protected function getIdentifierPath($identifier)
    {
        return preg_replace('~/execute$~', '', $this->url) . $identifier; // remove /execute from path
    }
}
