<?php

/**
 * @copyright 2022 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver;

/**
 * WebDriver\LegacyElement class
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
 * @method array property($propertyName) Get element property.
 * @method array rect() Get element rect.
 * @method array screenshot() Take element screenshot.
 * @method array size() Determine an element's size in pixels.
 * @method void submit() Submit a FORM element.
 * @method string text() Returns the visible text for the element.
 * @method void postValue($json) Send a sequence of key strokes to an element.
 */
class LegacyElement extends Element
{
    const LEGACY_ELEMENT_ID = 'ELEMENT';
}
