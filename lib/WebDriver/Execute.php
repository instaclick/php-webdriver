<?php

/**
 * @copyright 2017 Anthon Pang
 * @license Apache-2.0
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\Execute class
 */
class Execute extends AbstractWebDriver
{
    /**
     * Inject a snippet of JavaScript into the page for execution in the context of the currently selected frame. (asynchronous)
     *
     * @param array{script: string, args: array} $parameters
     *
     * @return mixed
     */
    public function async(array $parameters)
    {
        $parameters['args'] = $this->serializeArguments($parameters['args']);

        $result = $this->curl('POST', '/async', $parameters);

        return $this->unserializeResult($result['value']);
    }

    /**
     * Inject a snippet of JavaScript into the page for execution in the context of the currently selected frame. (synchronous)
     *
     * @param array{script: string, args: array} $parameters
     *
     * @return mixed
     */
    public function sync(array $parameters)
    {
        $parameters['args'] = $this->serializeArguments($parameters['args']);

        $result = $this->curl('POST', '/sync', $parameters);

        return $this->unserializeResult($result['value']);
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
