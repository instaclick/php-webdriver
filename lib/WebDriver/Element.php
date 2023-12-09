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

/**
 * WebDriver\Element class
 *
 * @package WebDriver
 *
 * W3C
 * @method string attribute($attributeName) Get the value of an element's attribute.
 * @method void clear() Clear a TEXTAREA or text INPUT element's value.
 * @method void click() Click on an element.
 * @method array computedlabel() Get ARIA Role.
 * @method array computedrole() Get Accessible Name.
 * @method string css($propertyName) Query the value of an element's computed CSS property.
 * @method boolean enabled() Determine if an element is currently enabled.
 * @method string name() Query for an element's tag name.
 * @method array property($propertyName) Get element property.
 * @method array rect() Get element rect.
 * @method array screenshot() Take element screenshot.
 * @method boolean selected() Is element selected?
 * @method string text() Returns the visible text for the element.
 * @method void value($parameters) Send a sequence of key strokes to an element.
 * Selenium
 * @method boolean equals($otherId) Test if two element IDs refer to the same DOM element.
 * @method array location() Determine an element's location on the page.
 * @method array size() Determine an element's size in pixels.
 */
class Element extends Container
{
    const WEB_ELEMENT_ID = 'element-6066-11e4-a52e-4f735466cecf';

    /**
     * Element ID
     *
     * @var string
     */
    private $id;

    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return [
            'attribute'     => ['GET'],
            'clear'         => ['POST'],
            'click'         => ['POST'],
            'computedlabel' => ['GET'],
            'computedrole'  => ['GET'],
            'css'           => ['GET'],
            'enabled'       => ['GET'],
            'name'          => ['GET'],
            'property'      => ['GET'],
            'rect'          => ['GET'],
            'screenshot'    => ['GET'],
            'selected'      => ['GET'],
            'text'          => ['GET'],
            'value'         => ['POST'],

            // @deprecated
            'equals'        => ['GET'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function chainable()
    {
        return [
            'shadow' => 'getShadowRoot',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return [
            // @deprecated
            'location'  => 'rect',
            'size'      => 'rect',
            'postValue' => 'sendKeys',
        ];
    }

    /**
     * Constructor
     *
     * @param string $url URL
     * @param string $id  element ID
     */
    public function __construct($url, $id)
    {
        parent::__construct($url . "/$id");

        $this->id = $id;
    }

    /**
     * Get element ID
     *
     * @return string
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * Get Accessible Name: /session/:sessionId/element/:elementId/computedlabel
     *
     * @return mixed
     */
    public function getAccessibleName()
    {
        $result = $this->curl('GET', 'computedlabel');

        return $result['value'];
    }

    /**
     * Get ARIA Role: /session/:sessionId/element/:elementId/computedrole
     *
     * @return mixed
     */
    public function getAriaRole()
    {
        $result = $this->curl('GET', 'computedrole');

        return $result['value'];
    }

    /**
     * Get element shadow root: /session/:sessionId/element/:elementId/shadow
     *
     * shadow root method chaining, e.g.,
     * - $element->shadow()->method()
     * - $element->shadow->method()
     *
     * @return \WebDriver\Shadow|null
     *
     */
    public function getShadowRoot()
    {
        $result = $this->curl('POST', 'shadow');
        $value  = $result['value'];

        if (! is_array($value)) {
            $value = [$value];
        }

        if (array_key_exists(Shadow::SHADOW_ROOT_ID, $value)) {
            $shadowRootReference = $value[Shadow::SHADOW_ROOT_ID];

            return new Shadow($this->getSessionPath() . '/shadow', $shadowRootReference);
        }

        return null;
    }

    /**
     * Is Element Enabled: /session/:sessionId/element/:elementId/enabled
     *
     * @return mixed
     */
    public function isEnabled()
    {
        $result = $this->curl('GET', 'enabled');

        return $result['value'];
    }

    /**
     * Is Element Selected: /session/:sessionId/element/:elementId/selected
     *
     * @return mixed
     */
    public function isSelected()
    {
        $result = $this->curl('GET', 'selected');

        return $result['value'];
    }

    /**
     * Send Keys to Element: /session/:sessionId/element/:elementId/value
     *
     * @param array|string $text Parameters {text: ...}
     *
     * @return mixed
     */
    public function sendKeys($text)
    {
        $parameters = is_array($text)
            ? $text
            : ['text' => $text, 'value' => [$text]];

        if (! array_key_exists('text', $parameters) && array_key_exists('value', $parameters)) {
            // trigger_error(__METHOD__ . ': use "text" property instead of "value"', E_USER_DEPRECATED);

            $parameters['text'] = implode($parameters['value']);
        }

        if (array_key_exists('text', $parameters) && ! array_key_exists('value', $parameters)) {
            $parameters['value'] = [$parameters['text']];
        }

        $result = $this->curl('POST', 'value', $parameters);

        return $result['value'];
    }

    /**
     * Submit a FORM Element: /session/:sessionId/element/:elementId/submit
     *
     * @deprecated
     *
     * @return mixed
     */
    public function submit()
    {
        // trigger_error(__METHOD__, E_USER_DEPRECATED);

        try {
            $result = $this->curl('POST', 'submit');

            return $result['value'];
        } catch (\Exception $e) {
            $session = new Session($this->getSessionPath(), []);

            return $session->execute()->sync(
                ['script' => <<<JS
var elem = arguments[0];
elem.submit();
JS
                , 'args' => [$this]]
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getNewIdentifierPath($identifier)
    {
        return preg_replace('~/' . preg_quote($this->id) . '$~', "/$identifier", $this->url);
    }

    /**
     * Get session path
     *
     * @return string
     */
    private function getSessionPath()
    {
        // remove /element/:elementid
        return preg_replace('~/element/' . preg_quote($this->id) . '$~', '', $this->url);
    }
}
