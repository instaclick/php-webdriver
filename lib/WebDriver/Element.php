<?php

/**
 * @copyright 2004 Meta Platforms, Inc.
 * @license Apache-2.0
 *
 * @author Justin Bishop <jubishop@gmail.com>
 */

namespace WebDriver;

/**
 * WebDriver\Element class
 *
 * @method void clear() Clear a TEXTAREA or text INPUT element's value.
 * @method void click() Click on an element.
 * @method boolean displayed() Determine if an element is currently displayed.
 * @method boolean enabled() Determine if an element is currently enabled.
 * @method boolean equals($otherId) Test if two element IDs refer to the same DOM element.
 * @method array location() Determine an element's location on the page.
 * @method array location_in_view() Determine an element's location on the screen once it has been scrolled into view.
 * @method string name() Query for an element's tag name.
 * @method array rect() Get element rect.
 * @method array screenshot() Take element screenshot.
 * @method array selected() Is element selected?
 * @method array size() Determine an element's size in pixels.
 * @method void submit() Submit a FORM element.
 * @method string text() Returns the visible text for the element.
 * @method void postValue($parameters) Send a sequence of key strokes to an element.
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
            'clear'         => ['POST'],
            'click'         => ['POST'],
            'computedlabel' => ['GET'],
            'computedrole'  => ['GET'],
            'enabled'       => ['GET'],
            'name'          => ['GET'],
            'rect'          => ['GET'],
            'screenshot'    => ['GET'],
            'selected'      => ['GET'],
            'text'          => ['GET'],
            'value'         => ['POST'],

            // Legacy JSON Wire Protocol
            'displayed'        => ['GET'], /** @see https://w3c.github.io/webdriver/#element-displayedness */
            'equals'           => ['GET'],
            'location'         => ['GET'],
            'location_in_view' => ['GET'],
            'size'             => ['GET'],
            'submit'           => ['POST'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function obsoleteMethods()
    {
        return [
            'active'   => ['GET'],
            'drag'     => ['POST'],
            'hover'    => ['POST'],
            'selected' => ['POST'],
            'toggle'   => ['POST'],
            'value'    => ['GET'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function chainable()
    {
        return [
            'shadow' => 'shadow',
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
     * Get the value of an element's attribute: /session/:sessionId/element/:id/attribute/:name
     *
     * @param string $name
     *
     * @return mixed
     */
    public function attribute($name)
    {
        $result = $this->curl('GET', "/attribute/$name");

        return $result['value'];
    }

    /**
     * Query the value of an element’s computed CSS property: /session/:sessionId/element/:id/css/:propertyName
     *
     * @param string $propertyName
     *
     * @return mixed
     */
    public function css($propertyName)
    {
        $result = $this->curl('GET', "/css/$propertyName");

        return $result['value'];
    }

    /**
     * Get element property: /session/:sessionId/element/:id/property/:name
     *
     * @param string $name
     *
     * @return mixed
     */
    public function property($name)
    {
        $result = $this->curl('GET', "/property/$name");

        return $result['value'];
    }

    /**
     * Get element shadow root: /session/:sessionId/element/:elementId/shadow
     *
     * shadow root method chaining, e.g.,
     * - $element->method()
     *
     * @return \WebDriver\Shadow|null
     */
    public function shadow()
    {
        $result = $this->curl('POST', '/shadow');
        $value  = $result['value'];

        if (array_key_exists(Shadow::SHADOW_ROOT_ID, (array) $value)) {
            $shadowRootReference = $value[Shadow::SHADOW_ROOT_ID];

            return new Shadow(
                preg_replace('~/element/' . preg_quote($this->id, '~') . '$~', '', $this->url), // remove /element/:elementid
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
        return preg_replace('~/' . preg_quote($this->id, '~') . '$~', $identifier, $this->url);
    }
}
