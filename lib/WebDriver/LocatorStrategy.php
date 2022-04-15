<?php

/**
 * @copyright 2011 Fabrizio Branca
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Fabrizio Branca <mail@fabrizio-branca.de>
 */

namespace WebDriver;

/**
 * WebDriver\LocatorStrategy class
 *
 * @package WebDriver
 */
final class LocatorStrategy
{
    const CLASS_NAME        = 'class name';
    const CSS_SELECTOR      = 'css selector';
    const ID                = 'id';
    const NAME              = 'name';
    const LINK_TEXT         = 'link text';
    const PARTIAL_LINK_TEXT = 'partial link text';
    const TAG_NAME          = 'tag name';
    const XPATH             = 'xpath';
}
