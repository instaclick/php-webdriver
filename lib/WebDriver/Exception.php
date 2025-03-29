<?php

/**
 * @copyright 2004 Meta Platforms, Inc.
 * @license Apache-2.0
 *
 * @author Justin Bishop <jubishop@gmail.com>
 */

namespace WebDriver;

use WebDriver\Exception as E;

/**
 * WebDriver\Exception class
 */
abstract class Exception extends \Exception
{
    /**
     * Response status codes
     *
     * @see https://github.com/SeleniumHQ/selenium/blob/trunk/java/src/org/openqa/selenium/remote/ErrorCodes.java
     */
    const SUCCESS = 0;
    const NO_SUCH_DRIVER = 6;
    const NO_SUCH_ELEMENT = 7;
    const NO_SUCH_FRAME = 8;
    const UNKNOWN_COMMAND = 9;
    const STALE_ELEMENT_REFERENCE = 10;
    const INVALID_ELEMENT_STATE = 12;
    const UNKNOWN_ERROR = 13;
    const JAVASCRIPT_ERROR = 17;
    const XPATH_LOOKUP_ERROR = 19;
    const TIMEOUT = 21;
    const NO_SUCH_WINDOW = 23;
    const INVALID_COOKIE_DOMAIN = 24;
    const UNABLE_TO_SET_COOKIE = 25;
    const UNEXPECTED_ALERT_OPEN = 26;
    const NO_ALERT_OPEN_ERROR = 27;
    const SCRIPT_TIMEOUT = 28;
    const INVALID_ELEMENT_COORDINATES = 29;
    const IME_NOT_AVAILABLE = 30;
    const IME_ENGINE_ACTIVATION_FAILED = 31;
    const INVALID_SELECTOR = 32;
    const SESSION_NOT_CREATED = 33;
    const MOVE_TARGET_OUT_OF_BOUNDS = 34;
    const INVALID_XPATH_SELECTOR = 51;
    const INVALID_XPATH_SELECTOR_RETURN_TYPER = 52;
    const ELEMENT_NOT_INTERACTABLE = 60;
    const INVALID_ARGUMENT = 61;
    const NO_SUCH_COOKIE = 62;
    const UNABLE_TO_CAPTURE_SCREEN = 63;
    const ELEMENT_CLICK_INTERCEPTED = 64;
    const NO_SUCH_SHADOW_ROOT = 65;
    const METHOD_NOT_ALLOWED = 405;

    // obsolete
    const INDEX_OUT_OF_BOUNDS = 1;
    const NO_COLLECTION = 2;
    const NO_STRING = 3;
    const NO_STRING_LENGTH = 4;
    const NO_STRING_WRAPPER = 5;
    const OBSOLETE_ELEMENT = 10;
    const ELEMENT_NOT_DISPLAYED = 11;
    const ELEMENT_NOT_VISIBLE = 11;
    const UNHANDLED = 13;
    const EXPECTED = 14;
    const ELEMENT_IS_NOT_SELECTABLE = 15;
    const ELEMENT_NOT_SELECTABLE = 15;
    const NO_SUCH_DOCUMENT = 16;
    const UNEXPECTED_JAVASCRIPT = 17;
    const NO_SCRIPT_RESULT = 18;
    const NO_SUCH_COLLECTION = 20;
    const NULL_POINTER = 22;
    const NO_MODAL_DIALOG_OPEN_ERROR = 27;

    // user-defined
    const CURL_EXEC = -1;
    const OBSOLETE_COMMAND = -2;
    const NO_PARAMETERS_EXPECTED = -3;
    const JSON_PARAMETERS_EXPECTED = -4;
    const UNEXPECTED_PARAMETERS = -5;
    const INVALID_REQUEST = -6;
    const UNKNOWN_LOCATOR_STRATEGY = -7;
    const W3C_WEBDRIVER_ERROR = -8;

    private static $errs = [
        // self::SUCCESS and self::W3C_WEBDRIVER_ERROR are for internal use only

        self::NO_SUCH_DRIVER => [E\NoSuchDriver::class, 'A session is either terminated or not started'],
        self::NO_SUCH_ELEMENT => [E\NoSuchElement::class, 'An element could not be located on the page using the given search parameters.'],
        self::NO_SUCH_FRAME => [E\NoSuchFrame::class, 'A request to switch to a frame could not be satisfied because the frame could not be found.'],
        self::UNKNOWN_COMMAND => [E\UnknownCommand::class, 'The requested resource could not be found, or a request was received using an HTTP method that is not supported by the mapped resource.'],
        self::STALE_ELEMENT_REFERENCE => [E\StaleElementReference::class, 'An element command failed because the referenced element is no longer attached to the DOM.'],
        self::ELEMENT_NOT_VISIBLE => [E\ElementNotVisible::class, 'An element command could not be completed because the element is not visible on the page.'],
        self::INVALID_ELEMENT_STATE => [E\InvalidElementState::class, 'An element command could not be completed because the element is in an invalid state (e.g., attempting to click a disabled element).'],
        self::UNKNOWN_ERROR => [E\UnknownError::class, 'An unknown server-side error occurred while processing the command.'],
        self::ELEMENT_IS_NOT_SELECTABLE => [E\ElementNotSelectable::class, 'An attempt was made to select an element that cannot be selected.'],
        self::JAVASCRIPT_ERROR => [E\JavaScriptError::class, 'An error occurred while executing user supplied JavaScript.'],
        self::XPATH_LOOKUP_ERROR => [E\XPathLookupError::class, 'An error occurred while searching for an element by XPath.'],
        self::TIMEOUT => [E\Timeout::class, 'An operation did not complete before its timeout expired.'],
        self::NO_SUCH_WINDOW => [E\NoSuchWindow::class, 'A request to switch to a different window could not be satisfied because the window could not be found.'],
        self::INVALID_COOKIE_DOMAIN => [E\InvalidCookieDomain::class, 'An illegal attempt was made to set a cookie under a different domain than the current page.'],
        self::UNABLE_TO_SET_COOKIE => [E\UnableToSetCookie::class, 'A request to set a cookie\'s value could not be satisfied.'],
        self::UNEXPECTED_ALERT_OPEN => [E\UnexpectedAlertOpen::class, 'A modal dialog was open, blocking this operation'],
        self::NO_ALERT_OPEN_ERROR => [E\NoAlertOpenError::class, 'An attempt was made to operate on a modal dialog when one was not open.'],
        self::SCRIPT_TIMEOUT => [E\ScriptTimeout::class, 'A script did not complete before its timeout expired.'],
        self::INVALID_ELEMENT_COORDINATES => [E\InvalidElementCoordinates::class, 'The coordinates provided to an interactions operation are invalid.'],
        self::IME_NOT_AVAILABLE => [E\IMENotAvailable::class, 'IME was not available.'],
        self::IME_ENGINE_ACTIVATION_FAILED => [E\IMEEngineActivationFailed::class, 'An IME engine could not be started.'],
        self::INVALID_SELECTOR => [E\InvalidSelector::class, 'Argument was an invalid selector (e.g., XPath/CSS).'],
        self::SESSION_NOT_CREATED => [E\SessionNotCreated::class, 'A new session could not be created (e.g., a required capability could not be set).'],
        self::MOVE_TARGET_OUT_OF_BOUNDS => [E\MoveTargetOutOfBounds::class, 'Target provided for a move action is out of bounds.'],

        self::CURL_EXEC => [E\CurlExec::class, 'curl_exec() error.'],
        self::OBSOLETE_COMMAND => [E\ObsoleteCommand::class, 'This WebDriver command is obsolete.'],
        self::NO_PARAMETERS_EXPECTED => [E\NoParametersExpected::class, 'This HTTP request method expects no parameters.'],
        self::JSON_PARAMETERS_EXPECTED => [E\JsonParameterExpected::class, 'This POST request expects a JSON parameter (array).'],
        self::UNEXPECTED_PARAMETERS => [E\UnexpectedParameters::class, 'This command does not expect this number of parameters.'],
        self::INVALID_REQUEST => [E\InvalidRequest::class, 'This command does not support this HTTP request method.'],
        self::UNKNOWN_LOCATOR_STRATEGY => [E\UnknownLocatorStrategy::class, 'This locator strategy is not supported.'],
        self::INVALID_XPATH_SELECTOR => [E\InvalidSelector::class, 'Argument was an invalid selector.'],
        self::INVALID_XPATH_SELECTOR_RETURN_TYPER => [E\InvalidSelector::class, 'Argument was an invalid selector.'],
        self::ELEMENT_NOT_INTERACTABLE => [E\ElementNotInteractable::class, 'A command could not be completed because the element is not pointer- or keyboard interactable.'],
        self::INVALID_ARGUMENT => [E\InvalidArgument::class, 'The arguments passed to a command are either invalid or malformed.'],
        self::NO_SUCH_COOKIE => [E\NoSuchCookie::class, 'No cookie matching the given path name was found amongst the associated cookies of the current browsing context\'s active document.'],
        self::UNABLE_TO_CAPTURE_SCREEN => [E\UnableToCaptureScreen::class, 'A screen capture was made impossible.'],
        self::ELEMENT_CLICK_INTERCEPTED => [E\ElementClickIntercepted::class, 'The Element Click command could not be completed because the element receiving the events is obscuring the element that was requested clicked.'],
        self::NO_SUCH_SHADOW_ROOT => [E\NoSuchShadowRoot::class, 'The element does not have a shadow root.'],
        self::METHOD_NOT_ALLOWED => [E\UnsupportedOperation::class, 'Indicates that a command that should have executed properly cannot be supported for some reason.'],

        /** @see https://w3c.github.io/webdriver/#errors */
        'element click intercepted' => [E\ElementClickIntercepted::class, 'The Element Click command could not be completed because the element receiving the events is obscuring the element that was requested clicked.'],
        'element not interactable' => [E\ElementNotInteractable::class, 'A command could not be completed because the element is not pointer- or keyboard interactable.'],
        'invalid argument' => [E\InvalidArgument::class, 'The arguments passed to a command are either invalid or malformed.'],
        'invalid cookie domain' => [E\InvalidCookieDomain::class, 'An illegal attempt was made to set a cookie under a different domain than the current page.'],
        'invalid element state' => [E\InvalidElementState::class, 'A command could not be completed because the element is in an invalid state, e.g. attempting to clear an element that isn\'t both editable and resettable.'],
        'invalid selector' => [E\InvalidSelector::class, 'Argument was an invalid selector.'],
        'invalid session id' => [E\InvalidSessionID::class, 'Occurs if the given session id is not in the list of active sessions, meaning the session either does not exist or that it\'s not active.'],
        'javascript error' => [E\JavaScriptError::class, 'An error occurred while executing JavaScript supplied by the user.'],
        'move target out of bounds' => [E\MoveTargetOutOfBounds::class, 'The target for mouse interaction is not in the browser\'s viewport and cannot be brought into that viewport.'],
        'no such alert' => [E\NoSuchAlert::class, 'An attempt was made to operate on a modal dialog when one was not open.'],
        'no such cookie' => [E\NoSuchCookie::class, 'No cookie matching the given path name was found amongst the associated cookies of the current browsing context\'s active document.'],
        'no such element' => [E\NoSuchElement::class, 'An element could not be located on the page using the given search parameters.'],
        'no such frame' => [E\NoSuchFrame::class, 'A command to switch to a frame could not be satisfied because the frame could not be found.'],
        'no such window' => [E\NoSuchWindow::class, 'A command to switch to a window could not be satisfied because the window could not be found.'],
        'no such shadow root' => [E\NoSuchShadowRoot::class, 'The element does not have a shadow root.'],
        'script timeout error' => [E\ScriptTimeout::class, 'A script did not complete before its timeout expired.'],
        'session not created' => [E\SessionNotCreated::class, 'A new session could not be created.'],
        'stale element reference' => [E\StaleElementReference::class, 'A command failed because the referenced element is no longer attached to the DOM.'],
        'detached shadow root' => [E\DetachedShadowRoot::class, 'A command failed because the referenced shadow root is no longer attached to the DOM.'],
        'timeout' => [E\Timeout::class, 'An operation did not complete before its timeout expired.'],
        'unable to set cookie' => [E\UnableToSetCookie::class, 'A command to set a cookie\'s value could not be satisfied.'],
        'unable to capture screen' => [E\UnableToCaptureScreen::class, 'A screen capture was made impossible.'],
        'unexpected alert open' => [E\UnexpectedAlertOpen::class, 'A modal dialog was open, blocking this operation.'],
        'unknown command' => [E\UnknownCommand::class, 'A command could not be executed because the remote end is not aware of it.'],
        'unknown error' => [E\UnknownError::class, 'An unknown error occurred in the remote end while processing the command.'],
        'unknown method' => [E\UnknownMethod::class, 'The requested command matched a known URL but did not match an method for that URL.'],
        'unsupported operation' => [E\UnsupportedOperation::class, 'Indicates that a command that should have executed properly cannot be supported for some reason.'],

        // obsolete
        'element not selectable' => [E\ElementNotSelectable::class, 'An attempt was made to select an element that cannot be selected.'],
        'invalid coordinates' => [E\InvalidCoordinates::class, 'The coordinates provided to an interactions operation are invalid.'],
        'script timeout' => [E\ScriptTimeout::class, 'A script did not complete before its timeout expired.'],
    ];

    /**
     * Factory method to create WebDriver\Exception objects
     *
     * @param integer|string $code              Code
     * @param string         $message           Message
     * @param \Exception     $previousException Previous exception
     *
     * @return \Exception
     */
    public static function factory($code, $message = null, $previousException = null)
    {
        // unknown error
        if (! isset(self::$errs[$code])) {
            $code = self::UNKNOWN_ERROR;
        }

        $errorDefinition = self::$errs[$code];

        if ($message === null || trim($message) === '') {
            $message = $errorDefinition[1];
        }

        if (! is_numeric($code)) {
            $code = self::W3C_WEBDRIVER_ERROR;
        }

        $className = $errorDefinition[0];

        return new $className($message, $code, $previousException);
    }
}
