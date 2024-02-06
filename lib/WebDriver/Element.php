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
 * @method string attribute($attributeName) Get the value of an element's attribute.
 * @method void clear() Clear a TEXTAREA or text INPUT element's value.
 * @method void click() Click on an element.
 * @method string css($propertyName) Query the value of an element's computed CSS property.
 * @method boolean displayed() Determine if an element is currently displayed.
 * @method boolean enabled() Determine if an element is currently enabled.
 * @method boolean equals($otherId) Test if two element IDs refer to the same DOM element.
 * @method array location() Determine an element's location on the page.
 * @method array location_in_view() Determine an element's location on the screen once it has been scrolled into view.
 * @method string name() Query for an element's tag name.
 * @method mixed property($propertyName) Get element property.
 * @method array rect() Get element rect.
 * @method array screenshot() Take element screenshot.
 * @method boolean selected() Is element selected?
 * @method array size() Determine an element's size in pixels.
 * @method void submit() Submit a FORM element.
 * @method string text() Returns the visible text for the element.
 * @method void postValue($json) Send a sequence of key strokes to an element.
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
        return array(
            'attribute' => array('GET'),
            'clear' => array('POST'),
            'click' => array('POST'),
            'css' => array('GET'),
            'enabled' => array('GET'),
            'name' => array('GET'),
            'property' => array('GET'),
            'rect' => array('GET'),
            'screenshot' => array('GET'),
            'selected' => array('GET'),
            'text' => array('GET'),
            'value' => array('POST'),

            // Legacy JSON Wire Protocol
            'displayed' => array('GET'),        // @see https://w3c.github.io/webdriver/#element-displayedness
            'equals' => array('GET'),
            'location' => array('GET'),
            'location_in_view' => array('GET'),
            'size' => array('GET'),
            'submit' => array('POST'),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function obsoleteMethods()
    {
        return array(
            'active' => array('GET'),
            'computedlabel' => array('GET'),
            'computedrole' => array('GET'),
            'drag' => array('POST'),
            'hover' => array('POST'),
            'selected' => array('POST'),
            'toggle' => array('POST'),
            'value' => array('GET'),
        );
    }

    /**
     * Constructor
     *
     * @param string $url URL
     * @param string $id  element ID
     */
    public function __construct($url, $id)
    {
        parent::__construct($url);

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
     * Get element shadow root: /session/:sessionId/element/:elementId/shadow
     *
     * shadow root method chaining, e.g.,
     * - $element->method()
     *
     * @return \WebDriver\Shadow|null
     *
     */
    public function shadow()
    {
        $result = $this->curl('POST', '/shadow');
        $value  = $result['value'];

        if (array_key_exists(Shadow::SHADOW_ROOT_ID, (array) $value)) {
            $shadowRootReference = $value[Shadow::SHADOW_ROOT_ID];

            return new Shadow(
                preg_replace('/' . preg_quote('element/' . $this->id, '/') . '$/', '/', $this->url), // remove /element/:elementid
                $shadowRootReference
            );
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    protected function getIdentifierPath($identifier)
    {
        return preg_replace('/' . preg_quote($this->id) . '$/', $identifier, $this->url);
    }
}
