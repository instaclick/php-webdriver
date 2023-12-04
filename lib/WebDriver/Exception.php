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

use WebDriver\Exception as E;

/**
 * WebDriver\Exception class
 *
 * @package WebDriver
 */
abstract class Exception extends \Exception
{
    /**
     * Error codes
     *
     * @see https://www.w3.org/TR/webdriver2/#errors
     */
    const DETACHED_SHADOW_ROOT      = 'detached shadow roomt';
    const ELEMENT_CLICK_INTERCEPTED = 'element click intercepted';
    const ELEMENT_NOT_INTERACTABLE  = 'element not interactable';
    const INSECURE_CERTIFICATE      = 'insecure certificate';
    const INVALID_ARGUMENT          = 'invalid argument';
    const INVALID_COOKIE_DOMAIN     = 'invalid cookie domain';
    const INVALID_ELEMENT_STATE     = 'invalid element state';
    const INVALID_SELECTOR          = 'invalid selector';
    const INVALID_SESSION_ID        = 'invalid session id';
    const JAVASCRIPT_ERROR          = 'javascript error';
    const MOVE_TARGET_OUT_OF_BOUNDS = 'move target out of bounds';
    const NO_SUCH_ALERT             = 'no such alert';
    const NO_SUCH_COOKIE            = 'no such cookie';
    const NO_SUCH_ELEMENT           = 'no such element';
    const NO_SUCH_FRAME             = 'no such frame';
    const NO_SUCH_SHADOW_ROOT       = 'no such shadow root';
    const NO_SUCH_WINDOW            = 'no such window';
    const SCRIPT_TIMEOUT            = 'script timeout';
    const SESSION_NOT_CREATED       = 'session not created';
    const STALE_ELEMENT_REFERENCE   = 'stale element reference';
    const TIMEOUT                   = 'timeout';
    const UNABLE_TO_CAPTURE_SCREEN  = 'unable to capture screen';
    const UNABLE_TO_SET_COOKIE      = 'unable to set cookie';
    const UNEXPECTED_ALERT_OPEN     = 'unexpected alert open';
    const UNKNOWN_COMMAND           = 'unknown command';
    const UNKNOWN_ERROR             = 'unknown error';
    const UNKNOWN_METHOD            = 'unknown method';
    const UNSUPPORTED_OPERATION     = 'unsupported operation';

    // @internal php-webdriver
    const _CURL_EXEC                = 'curl exec';
    const _INVALID_REQUEST          = 'invalid request';
    const _JSON_PARAMETERS_EXPECTED = 'json parameters expected';
    const _NO_PARAMETERS_EXPECTED   = 'no parameters expected';
    const _OBSOLETE_COMMAND         = 'obsolete command';
    const _UNEXPECTED_PARAMETERS    = 'unexpected parameters';
    const _UNKNOWN_LOCATOR_STRATEGY = 'unknown locator strategy';

    /**
     * Mapping JSON Wire Protocol (integer) error codes to W3C WebDriver (string) status codes
     *
     * @deprecated
     *
     * @see https://github.com/SeleniumHQ/selenium/blob/trunk/java/src/org/openqa/selenium/remote/ErrorCodes.java
     *
     * @var array
     */
    private static $mapping = [
        1   => 'index out of bounds',
        2   => 'no collection',
        3   => 'no string',
        4   => 'no string length',
        5   => 'no string wrapper',
        6   => self::SESSION_NOT_CREATED,       // 'no such driver'
        7   => self::NO_SUCH_ELEMENT,
        8   => self::NO_SUCH_FRAME,
        9   => self::UNSUPPORTED_OPERATION,
        10  => self::STALE_ELEMENT_REFERENCE,   // 'obsolete element'
        11  => 'element not displayed',
        12  => self::INVALID_ELEMENT_STATE,
        13  => self::UNKNOWN_ERROR,
        14  => 'expected',
        15  => self::ELEMENT_NOT_INTERACTABLE,  // 'element is not selectable'
        16  => 'no such document',
        17  => self::JAVASCRIPT_ERROR,
        18  => 'no script result',
        19  => self::INVALID_SELECTOR,          // 'xpath lookup error'
        20  => 'no such collection',
        21  => self::TIMEOUT,
        22  => 'null pointer',
        23  => self::NO_SUCH_WINDOW,
        24  => self::INVALID_COOKIE_DOMAIN,
        25  => self::UNABLE_TO_SET_COOKIE,
        26  => self::UNEXPECTED_ALERT_OPEN,
        27  => self::NO_SUCH_ALERT,             // 'no modal dialog open error'
        28  => self::SCRIPT_TIMEOUT,
        29  => 'invalid element coordinates',
        30  => 'ime not available',
        31  => 'ime engine activation failed',
        32  => self::INVALID_SELECTOR,
        33  => self::SESSION_NOT_CREATED,
        34  => self::MOVE_TARGET_OUT_OF_BOUNDS,
        35  => 'sql database error',
        51  => self::INVALID_SELECTOR,          // 'invalid xpath selector'
        52  => self::INVALID_SELECTOR,          // 'invalid xpath selector return typer'
        60  => self::ELEMENT_NOT_INTERACTABLE,
        61  => self::INVALID_ARGUMENT,
        62  => self::NO_SUCH_COOKIE,
        63  => self::UNABLE_TO_CAPTURE_SCREEN,
        64  => self::ELEMENT_CLICK_INTERCEPTED,
        65  => self::NO_SUCH_SHADOW_ROOT,
        405 => self::UNSUPPORTED_OPERATION,     // 'method not allowed'
    ];

    /**
     * Error data dictionary
     *
     * @var array
     */
    private static $errs = [
        self::DETACHED_SHADOW_ROOT => [E\DetachedShadowRoot::class, 'A command failed because the referenced shadow root is no longer attached to the DOM.'],
        self::ELEMENT_CLICK_INTERCEPTED => [E\ElementClickIntercepted::class, 'The Element Click command could not be completed because the element receiving the events is obscuring the element that was requested clicked.'],
        self::ELEMENT_NOT_INTERACTABLE => [E\ElementNotInteractable::class, 'A command could not be completed because the element is not pointer- or keyboard interactable.'],
        self::INSECURE_CERTIFICATE => [E\InsecureCertificate::class, 'Navigation caused the user agent to hit a certificate warning, which is usually the result of an expired or invalid TLS certificate.'],
        self::INVALID_ARGUMENT => [E\InvalidArgument::class, 'The arguments passed to a command are either invalid or malformed.'],
        self::INVALID_COOKIE_DOMAIN => [E\InvalidCookieDomain::class, 'An illegal attempt was made to set a cookie under a different domain than the current page.'],
        self::INVALID_ELEMENT_STATE => [E\InvalidElementState::class, 'A command could not be completed because the element is in an invalid state, e.g. attempting to clear an element that isn\'t both editable and resettable.'],
        self::INVALID_SELECTOR => [E\InvalidSelector::class, 'Argument was an invalid selector.'],
        self::INVALID_SESSION_ID => [E\InvalidSessionID::class, 'Occurs if the given session id is not in the list of active sessions, meaning the session either does not exist or that it\'s not active.'],
        self::JAVASCRIPT_ERROR => [E\JavaScriptError::class, 'An error occurred while executing JavaScript supplied by the user.'],
        self::MOVE_TARGET_OUT_OF_BOUNDS => [E\MoveTargetOutOfBounds::class, 'The target for mouse interaction is not in the browser\'s viewport and cannot be brought into that viewport.'],
        self::NO_SUCH_ALERT => [E\NoSuchAlert::class, 'An attempt was made to operate on a modal dialog when one was not open.'],
        self::NO_SUCH_COOKIE => [E\NoSuchCookie::class, 'No cookie matching the given path name was found amongst the associated cookies of the current browsing context\'s active document.'],
        self::NO_SUCH_ELEMENT => [E\NoSuchElement::class, 'An element could not be located on the page using the given search parameters.'],
        self::NO_SUCH_FRAME => [E\NoSuchFrame::class, 'A command to switch to a frame could not be satisfied because the frame could not be found.'],
        self::NO_SUCH_SHADOW_ROOT => [E\NoSuchShadowRoot::class, 'The element does not have a shadow root.'],
        self::NO_SUCH_WINDOW => [E\NoSuchWindow::class, 'A command to switch to a window could not be satisfied because the window could not be found.'],
        self::SCRIPT_TIMEOUT => [E\ScriptTimeout::class, 'A script did not complete before its timeout expired.'],
        self::SESSION_NOT_CREATED => [E\SessionNotCreated::class, 'A new session could not be created.'],
        self::STALE_ELEMENT_REFERENCE => [E\StaleElementReference::class, 'A command failed because the referenced element is no longer attached to the DOM.'],
        self::TIMEOUT => [E\Timeout::class, 'An operation did not complete before its timeout expired.'],
        self::UNABLE_TO_CAPTURE_SCREEN => [E\UnableToCaptureScreen::class, 'A screen capture was made impossible.'],
        self::UNABLE_TO_SET_COOKIE => [E\UnableToSetCookie::class, 'A command to set a cookie\'s value could not be satisfied.'],
        self::UNEXPECTED_ALERT_OPEN => [E\UnexpectedAlertOpen::class, 'A modal dialog was open, blocking this operation.'],
        self::UNKNOWN_COMMAND => [E\UnknownCommand::class, 'A command could not be executed because the remote end is not aware of it.'],
        self::UNKNOWN_ERROR => [E\UnknownError::class, 'An unknown error occurred in the remote end while processing the command.'],
        self::UNKNOWN_METHOD => [E\UnknownMethod::class, 'The requested command matched a known URL but did not match an method for that URL.'],
        self::UNSUPPORTED_OPERATION => [E\UnsupportedOperation::class, 'Indicates that a command that should have executed properly cannot be supported for some reason.'],

        // @internal php-webdriver (user-defined)
        self::_CURL_EXEC => [E\CurlExec::class, 'curl_exec() error.'],
        self::_INVALID_REQUEST => [E\InvalidRequest::class, 'This command does not support this HTTP request method.'],
        self::_JSON_PARAMETERS_EXPECTED => [E\JsonParameterExpected::class, 'This POST request expects a JSON parameter (array).'],
        self::_NO_PARAMETERS_EXPECTED => [E\NoParametersExpected::class, 'This HTTP request method expects no parameters.'],
        self::_OBSOLETE_COMMAND => [E\ObsoleteCommand::class, 'This WebDriver command is obsolete.'],
        self::_UNEXPECTED_PARAMETERS => [E\UnexpectedParameters::class, 'This command does not expect this number of parameters.'],
        self::_UNKNOWN_LOCATOR_STRATEGY => [E\UnknownLocatorStrategy::class, 'This locator strategy is not supported.'],
    ];

    /**
     * Factory method to create WebDriver\Exception objects
     *
     * @param string|integer $code              Status (or Error) Code
     * @param string         $message           Message
     * @param \Exception     $previousException Previous exception
     *
     * @return \Exception
     */
    public static function factory($code, $message = null, $previousException = null)
    {
        if (is_numeric($code) && array_key_exists($code, self::$mapping)) {
            $code = self::$mapping[$code];
        }

        if (! array_key_exists($code, self::$errs)) {
            $code = self::UNKNOWN_ERROR;
        }

        $errorDefinition = self::$errs[$code];
        $className = $errorDefinition[0];

        if ($message === null || trim($message) === '') {
            $message = $errorDefinition[1];
        }

        return new $className($message, 0, $previousException);
    }
}
