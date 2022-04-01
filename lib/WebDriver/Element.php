<?php

/**
 * Copyright 2004-2022 Facebook. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package WebDriver
 *
 * @author Justin Bishop <jubishop@gmail.com>
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 * @author Fabrizio Branca <mail@fabrizio-branca.de>
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
 * @method array property($propertyName) Get Element Property
 * @method array rect() Get Element Rect
 * @method array screenshot() Take Element Screenshot
 * @method array size() Determine an element's size in pixels.
 * @method void submit() Submit a FORM element.
 * @method string text() Returns the visible text for the element.
 * @method void postValue($json) Send a sequence of key strokes to an element.
 */
final class Element extends Container
{
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
            'displayed' => array('GET'),
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
     * Element ID
     *
     * @var string
     */
    private $id;

    /**
     * Constructor
     *
     * @param string  $url    URL
     * @param string  $id     element ID
     * @param boolean $legacy Is legacy?
     */
    public function __construct($url, $id, $legacy)
    {
        parent::__construct($url, $legacy);

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
     * @return \WebDriver\Shadow
     *
     */
    public function shadow()
    {
        return new Shadow($this->url . '/shadow', $this->legacy);
    }

    /**
     * {@inheritdoc}
     */
    protected function getElementPath($elementId)
    {
        return preg_replace('/' . preg_quote($this->id, '/') . '$/', $elementId, $this->url);
    }
}
