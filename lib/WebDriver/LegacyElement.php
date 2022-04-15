<?php

/**
 * Copyright 2022-2022 Anthon Pang. All Rights Reserved.
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
 * @method array property($propertyName) Get Element Property
 * @method array rect() Get Element Rect
 * @method array screenshot() Take Element Screenshot
 * @method array size() Determine an element's size in pixels.
 * @method void submit() Submit a FORM element.
 * @method string text() Returns the visible text for the element.
 * @method void postValue($json) Send a sequence of key strokes to an element.
 */
class LegacyElement extends Element
{
    const LEGACY_ELEMENT_ID = 'ELEMENT';
}
