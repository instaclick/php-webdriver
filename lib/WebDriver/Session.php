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

use WebDriver\Extension\ChromeDevTools;
use WebDriver\Extension\FederatedCredentialManagementAPI;
use WebDriver\Extension\Selenium;
use WebDriver\Extension\WebAuthenticationAPI;

/**
 * WebDriver\Session class
 *
 * @package WebDriver
 *
 * W3C
 * @method array deleteActions() Release actions.
 * @method array postActions($parameters) Perform actions.
 * @method void back() Navigates backward in the browser history, if possible.
 * @method array getCookie() Retrieve all cookies visible to the current page.
 * @method array postCookie($parameters) Set a cookie.
 * @method void forward() Navigates forward in the browser history, if possible.
 * @method array print() Print page.
 * @method void refresh() Refresh the current page.
 * @method string screenshot() Take a screenshot of the current page.
 * @method string source() Get the current page source.
 * @method string title() Get the current page title.
 * @method string url() Retrieve the URL of the current page.
 * @method void postUrl($parameters) Navigate to a new URL.
 * Selenium
 * @method boolean getBrowser_connection() Is browser online?
 * @method void postBrowser_connection($parameters) Set browser online.
 * @method array context() Get current context handle.
 * @method void postContext() Switch to context.
 * @method array contexts() Get context handles.
 * @method array getLocation() Get the current geo location.
 * @method void postLocation($parameters) Set the current geo location.
 * @method string getNetworkConnection() Get the network connection.
 * @method void postNetworkConnection($parameters) Set the network connection.
 * @method string getOrientation() Get the current browser orientation.
 * @method void postOrientation($parameters) Set the current browser orientation.
 * @method string getRotation() Get screen rotation.
 * @method void postOrientation($parameters) Set screen rotation.
 */
class Session extends Container
{
    /**
     * @var array
     */
    private $capabilities = null;

    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return [
            'actions'            => ['POST', 'DELETE'],
            'back'               => ['POST'],
            'cookie'             => ['GET', 'POST'], // for DELETE, use deleteAllCookies()
            'forward'            => ['POST'],
            'print'              => ['POST'],
            'refresh'            => ['POST'],
            'screenshot'         => ['GET'],
            'source'             => ['GET'],
            'title'              => ['GET'],
            'url'                => ['GET', 'POST'], // alternate for POST, use open($url)

            // @deprecated
            'browser_connection' => ['GET', 'POST'],
            'context'            => ['GET', 'POST'],
            'contexts'           => ['GET'],
            'location'           => ['GET', 'POST'],
            'network_connection' => ['GET', 'POST'],
            'orientation'        => ['GET', 'POST'],
            'rotation'           => ['GET', 'POST'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function aliases()
    {
        return [
            'activeElement'     => 'getActiveElement',
            'addCookie'         => 'setCookie',
            'capabilities'      => 'getCapabilities',
            'closeWindow'       => 'deleteWindow',
            'focusWindow'       => 'switchToWindow',
            'get'               => 'open',
            'getCurrentUrl'     => 'getUrl',
            'getPageSource'     => 'source',
            'getPageTitle'      => 'title',
            'goBack'            => 'back',
            'goForward'         => 'forward',
            'goTo'              => 'open',
            'navigateTo'        => 'open',
            'printPage'         => 'print',
            'quit'              => 'close',

            // deprecated
            'application_cache' => 'applicationCache',
            'execute_async'     => 'executeAsyncScript',
            'isBrowserOnline'   => 'getBrowserConnection',
            'setBrowserOnline'  => 'setBrowserConnection',
            'window_handle'     => 'getWindowHandle',
            'window_handles'    => 'getWindowHandles',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function chainable()
    {
        return [
            'actions'  => 'actions',
            'alert'    => 'alert',
            'execute'  => 'execute',
            'frame'    => 'frame',
            'timeouts' => 'timeouts',
            'window'   => 'window',
        ];
    }

    /**
     * Constructor
     *
     * @param string     $url
     * @param array|null $capabilities
     */
    public function __construct($url, $capabilities)
    {
        // $url already includes :sessionId
        parent::__construct($url);

        $this->capabilities = $capabilities;

        $this->register('cdp', ChromeDevTools::class, 'goog/cdp');
        $this->register('fedcm', FederatedCredentialManagementAPI::class, 'fedcm');
        $this->register('selenium', Selenium::class, 'se');
        $this->register('webauthn', WebAuthenticationAPI::class, 'webauthn/authenticator');
    }

    /**
     * Get browser capabilities: /session/:sessionId (GET)
     *
     * @return mixed
     */
    public function getCapabilities()
    {
        if ($this->capabilities === null) {
            $result = $this->curl('GET', '');

            $this->capabilities = $result['value'];
        }

        return $this->capabilities;
    }

    /**
     * Open URL: /session/:sessionId/url (POST)
     * An alternative to $session->url($url);
     *
     * @param string $url
     *
     * @return \WebDriver\Session
     */
    public function open($url)
    {
        $this->curl('POST', 'url', ['url' => $url]);

        return $this;
    }

    /**
     * Close session: /session/:sessionId (DELETE)
     *
     * @return mixed
     */
    public function close()
    {
        $result = $this->curl('DELETE', '');

        return $result['value'];
    }

    // There's a limit to our ability to exploit the dynamic nature of PHP when it
    // comes to the cookie methods because GET and DELETE request methods are indistinguishable
    // from each other: neither takes parameters.

    /**
     * Get all cookies: /session/:sessionId/cookie (GET)
     * Alternative to: $session->cookie();
     *
     * Note: get cookie by name not implemented in API
     *
     * @return mixed
     */
    public function getAllCookies()
    {
        $result = $this->curl('GET', 'cookie');

        return $result['value'];
    }

    /**
     * Set cookie: /session/:sessionId/cookie (POST)
     * Alternative to: $session->cookie($parameters);
     *
     * @param array $cookieData
     *
     * @return \WebDriver\Session
     */
    public function setCookie($cookieData)
    {
        $parameters = array_key_exists('cookie', $cookieData)
            ? $cookieData
            : ['cookie' => $cookieData];

        $this->curl('POST', 'cookie', $parameters);

        return $this;
    }

    /**
     * Delete all cookies: /session/:sessionId/cookie (DELETE)
     *
     * @return \WebDriver\Session
     */
    public function deleteAllCookies()
    {
        $this->curl('DELETE', 'cookie');

        return $this;
    }

    /**
     * Delete a cookie: /session/:sessionId/cookie/:name (DELETE)
     *
     * @param string $cookieName
     *
     * @return \WebDriver\Session
     */
    public function deleteCookie($cookieName)
    {
        $this->curl('DELETE', 'cookie/' . $cookieName);

        return $this;
    }

    /**
     * Get window handle: /session/:sessionId/window (GET)
     * - $session->getWindowHandle()
     *
     * An alternative to $session->window()->getHandle()
     *
     * @return mixed
     */
    public function getWindowHandle()
    {
        $result = $this->curl('GET', 'window');

        return $result['value'];
    }

    /**
     * Get window handles: /session/:sessionId/window/handles (GET)
     * - $session->getWindowHandles()
     *
     * @return mixed
     */
    public function getWindowHandles()
    {
        $result = $this->curl('GET', 'window/handles');

        return $result['value'];
    }

    /**
     * New window: /session/:sessionId/window/new (POST)
     * - $session->newWindow($type)
     *
     * @internal "new" is a reserved keyword in PHP, so $session->window()->new() isn't possible
     *
     * @param array|string $type Type or Paramters {type: ...}
     *
     * @return \WebDriver\Window
     */
    public function newWindow($type)
    {
        $parameters = is_array($type)
            ? $type
            : ['type' => $type];

        $result = $this->curl('POST', 'window/new', $parameters);

        return $result['value'];
    }

    /**
     * window method chaining: /session/:sessionId/window (POST)
     * - $session->window($parameters) - set focus
     * - $session->window($parameters)->method() - chaining
     * - $session->window()->method() - chaining
     *
     * @return \WebDriver\Session|\WebDriver\Window
     */
    public function window()
    {
        $arg = null;

        // set window focus / switch to window
        if (func_num_args() === 1) {
            return $this->switchToWindow(func_get_arg(0));
        }

        // chaining (with optional handle in $arg)
        return new Window($this->url . '/window', $arg);
    }

    /**
     * Close window: /session/:sessionId/window (DELETE)
     *
     * @return \WebDriver\Session
     */
    public function deleteWindow()
    {
        $this->curl('DELETE', 'window');

        return $this;
    }

    /**
     * Switch to window: /session/:sessionId/window (POST)
     *
     * @param mixed $handle window handle (or legacy name) attribute
     *
     * @return \WebDriver\Session
     */
    public function switchToWindow($handle)
    {
        $parameters = is_array($handle)
            ? $handle
            : ['handle' => $handle, 'name' => $handle];

        $this->curl('POST', 'window', $parameters);

        return $this;
    }

    /**
     * frame methods: /session/:sessionId/frame (POST)
     * - $session->frame($parameters) - change focus to another frame on the page
     * - $session->frame()->method() - chaining
     *
     * @param array|string $id
     *
     * @return \WebDriver\Session|\WebDriver\Frame
     */
    public function frame($id = null)
    {
        if (func_num_args() === 1) {
            $parameters = is_array($id)
                ? $id
                : ['id' => $id];

            $this->curl('POST', 'frame', $parameters);

            return $this;
        }

        // chaining
        return new Frame($this->url . '/frame');
    }

    /**
     * timeouts methods: /session/:sessionId/timeouts (POST)
     * - $session->timeouts($parameters) - set timeout for an operation
     * - $session->timeouts()->method() - chaining
     *
     * @return \WebDriver\Session|\WebDriver\Timeouts
     */
    public function timeouts()
    {
        // @deprecated
        if (func_num_args() > 0) {
            // trigger_error(__METHOD__ . ': use "Timeouts::setTimeout()" instead', E_USER_DEPRECATED);

            return call_user_func_array([$this, 'setTimeout'], func_get_args());
        }

        // chaining
        return new Timeouts($this->url . '/timeouts');
    }

    /**
     * Get timeouts: /session/:sessionId/timeouts (GET)
     * - $session->getTimeouts()
     *
     * @return mixed
     */
    public function getTimeouts()
    {
        return call_user_func([$this->timeouts(), 'getTimeouts']);
    }

    /**
     * Set timeout: /session/:sessionId/timeouts (POST)
     * - $session->setTimeout()
     *
     * @return mixed
     */
    public function setTimeout()
    {
        return call_user_func_array([$this->timeouts(), 'setTimeout'], func_get_args());
    }

    /**
     * Get active element (i.e., has focus): /session/:sessionId/element/active (POST)
     * - $session->activeElement()
     *
     * @return mixed
     */
    public function getActiveElement()
    {
        $result = $this->curl('POST', 'element/active');

        return $this->makeElement($result['value']);
    }

    /**
     * actions method chaining, e.g.,
     * - $session->actions()->method() - chaining
     * - $session->actions->method() - chaining
     *
     * @return mixed
     */
    protected function actions()
    {
        return Actions::getInstance($this->url . '/actions');
    }

    /**
     * alert method chaining, e.g.,
     * - $session->alert()->method() - chaining
     * - $session->alert->method() - chaining
     *
     * @return mixed
     */
    protected function alert()
    {
        return new Alert($this->url . '/alert');
    }

    /**
     * script execution method chaining, e.g.,
     * - $session->execute($parameters) - execute script
     * - $session->execute()->method() - chaining
     *
     * @return mixed
     */
    public function execute()
    {
        // @deprecated
        if (func_num_args() > 0) {
            // trigger_error(__METHOD__ . ': use "Execute::sync()" instead', E_USER_DEPRECATED);

            return call_user_func_array([$this, 'executeScript'], func_get_args());
        }

        return new Execute($this->url);
    }

    /**
     * async script execution: /session/:sessionId/execute_async
     *
     * @deprecated
     *
     * @return mixed
     */
    public function executeAsyncScript()
    {
        // trigger_error(__METHOD__ . ': use "Execute::async()" instead', E_USER_DEPRECATED);

        return call_user_func_array([$this->execute(), 'async'], func_get_args());
    }

    /**
     * sync script execution: /session/:sessionId/execute
     *
     * @deprecated
     *
     * @return mixed
     */
    public function executeScript()
    {
        // trigger_error(__METHOD__ . ': use "Execute::sync()" instead', E_USER_DEPRECATED);

        return call_user_func_array([$this->execute(), 'sync'], func_get_args());
    }

    /**
     * application cache chaining, e.g.,
     * - $session->application_cache()->method() - chaining
     *
     * @deprecated
     *
     * @return \WebDriver\ApplicationCache
     */
    public function applicationCache()
    {
        // trigger_error(__METHOD__, E_USER_DEPRECATED);

        return new ApplicationCache($this->url . '/application_cache');
    }

    /**
     * Move the mouse: /session/:sessionId/moveto (POST)
     *
     * @deprecated
     *
     * @param array $parameters
     *
     * @return mixed
     */
    public function moveto($parameters)
    {
        // trigger_error(__METHOD__ . ': use actions() API instead', E_USER_DEPRECATED);

        try {
            $result = $this->curl('POST', 'moveto', $parameters);
        } catch (\Exception $e) {
            if (! array_key_exists('element', $parameters)) {
                $actionItem = [
                    'x' => $parameters['xoffset'],
                    'y' => $parameters['yoffset'],
                ];
            } else {
                $element = new Element($this->url . '/element', $parameters['element']);
                $rect    = $element->rect();

                $actionItem = [
                    'x' => $rect['x'] + ($parameters['xoffset'] ?? $rect['width'] / 2),
                    'y' => $rect['y'] + ($parameters['yoffset'] ?? $rect['height'] / 2),
                ];
            }

            $mouse = $this->actions()->getPointerInput(0, PointerInput::MOUSE);

            $result = $this->actions()
                           ->addAction($mouse->pointerMove($actionItem))
                           ->perform();
        }

        return $result['value'];
    }

    /**
     * Click any mouse button: /session/:sessionId/click (POST)
     *
     * @deprecated
     *
     * @param array $parameters Parameters {button: ...}
     *
     * @return mixed
     */
    public function click($parameters)
    {
        // trigger_error(__METHOD__ . ': use actions() API instead', E_USER_DEPRECATED);

        try {
            $result = $this->curl('POST', 'click', $parameters);
        } catch (\Exception $e) {
            $mouse = $this->actions()->getPointerInput(0, PointerInput::MOUSE);

            $result = $this->actions()
                           ->addAction($mouse->pointerDown([
                                'button' => PointerInput::LEFT_BUTTON,
                             ]))
                           ->addAction($mouse->pointerUp([
                                'button' => PointerInput::LEFT_BUTTON,
                             ]))
                           ->perform();
        }

        return $result['value'];
    }

    /**
     * Double click left mouse button: /session/:sessionId/doubleclick (POST)
     *
     * @deprecated
     *
     * @param array $parameters Parameters
     *
     * @return mixed
     */
    public function doubleclick($parameters)
    {
        // trigger_error(__METHOD__ . ': use actions() API instead', E_USER_DEPRECATED);

        try {
            $result = $this->curl('POST', 'doubleclick', $parameters);
        } catch (\Exception $e) {
            $mouse = $this->actions()->getPointerInput(0, PointerInput::MOUSE);

            $result = $this->actions()
                           ->addAction($mouse->pointerDown([
                                'button' => PointerInput::LEFT_BUTTON,
                             ]))
                           ->addAction($mouse->pointerUp([
                                'button' => PointerInput::LEFT_BUTTON,
                             ]))
                           ->addAction($mouse->pointerDown([
                                'button' => PointerInput::LEFT_BUTTON,
                             ]))
                           ->addAction($mouse->pointerUp([
                                'button' => PointerInput::LEFT_BUTTON,
                             ]))
                           ->perform();
        }

        return $result['value'];
    }

    /**
     * Click and hold left mouse button down: /session/:sessionId/buttondown (POST)
     *
     * @deprecated
     *
     * @param array $parameters Parameters {button: ...}
     *
     * @return mixed
     */
    public function buttondown($parameters)
    {
        // trigger_error(__METHOD__ . ': use actions() API instead', E_USER_DEPRECATED);

        try {
            $result = $this->curl('POST', 'buttondown', $parameters);
        } catch (\Exception $e) {
            $mouse = $this->actions()->getPointerInput(0, PointerInput::MOUSE);

            $result = $this->actions()
                           ->addAction($mouse->pointerDown([
                                'button' => PointerInput::LEFT_BUTTON,
                             ]))
                           ->perform();
        }

        return $result['value'];
    }

    /**
     * Release mouse button: /session/:sessionId/buttonup (POST)
     *
     * @deprecated
     *
     * @param array $parameters Parameters {button: ...}
     *
     * @return mixed
     */
    public function buttonup($parameters)
    {
        // trigger_error(__METHOD__ . ': use actions() API instead', E_USER_DEPRECATED);

        try {
            $result = $this->curl('POST', 'buttonup', $parameters);
        } catch (\Exception $e) {
            $mouse = $this->actions()->getPointerInput(0, PointerInput::MOUSE);

            $result = $this->actions()
                           ->addAction($mouse->pointerUp([
                                'button' => PointerInput::LEFT_BUTTON,
                             ]))
                           ->perform();
        }

        return $result['value'];
    }

    /**
     * Gets the text of the currenty displayed Javascript dialog: /session/:sessionId/alert_text (GET)
     *
     * @deprecated
     *
     * @return mixed
     */
    public function getAlertText()
    {
        // trigger_error(__METHOD__ . ': use "Alert::getAlertText()" instead', E_USER_DEPRECATED);

        try {
            $result = $this->curl('GET', 'alert_text');
        } catch (\Exception $e) {
            $result = $this->alert()->getAlertText();
        }

        return $result['value'];
    }

    /**
     * Send keystrokes to a Javascript dialog: /session/:sessionId/alert_text (POST)
     *
     * @deprecated
     *
     * @param array|string $text Parameters {text: ...}
     *
     * @return mixed
     */
    public function postAlertText($text)
    {
        $parameters = is_array($text)
            ? $text
            : ['text' => $text];

        // trigger_error(__METHOD__ . ': use "Alert::setAlertText()" instead', E_USER_DEPRECATED);

        try {
            $result = $this->curl('POST', 'alert_text', $parameters);
        } catch (\Exception $e) {
            $result = $this->alert()->setAlertText();
        }

        return $result['value'];
    }

    /**
     * Accepts the currently displayed alert dialog: /session/:sessionId/accept_alert (POST)
     *
     * @deprecated
     *
     * @return mixed
     */
    public function acceptAlert()
    {
        // trigger_error(__METHOD__ . ': use "Alert::acceptAlert()" instead', E_USER_DEPRECATED);

        try {
            $result = $this->curl('POST', 'accept_alert');
        } catch (\Exception $e) {
            $result = $this->alert()->acceptAlert();
        }

        return $result['value'];
    }

    /**
     * Dismisses the currently displayed alert dialog: /session/:sessionId/dismiss_alert (POST)
     *
     * @deprecated
     *
     * @return mixed
     */
    public function dismissAlert()
    {
        // trigger_error(__METHOD__ . ': use "Alert::dismissAlert()" instead', E_USER_DEPRECATED);

        try {
            $result = $this->curl('POST', 'dismiss_alert');
        } catch (\Exception $e) {
            $result = $this->alert()->dismissAlert();
        }

        return $result['value'];
    }

    /**
     * Send a sequence of key strokes to the active element.: /session/:sessionId/keys (POST)
     *
     * @deprecated
     *
     * @param array|string $value Value or Parameters {value: ...}
     *
     * @return mixed
     */
    public function keys($value)
    {
        $parameters = is_array($value)
            ? $value
            : ['value' => $value];

        // trigger_error(__METHOD__ . ': use "Element::sendKeys()" instead', E_USER_DEPRECATED);

        try {
            $result = $this->curl('POST', 'keys', $parameters);
        } catch (\Exception $e) {
            $result = $this->getActiveElement()->sendKeys($parameters);
        }

        return $result['value'];
    }

    /**
     * Upload file: /session/:sessionId/file (POST)
     *
     * @deprecated
     *
     * @param array|string $file Parameters {file: ...}
     *
     * @return mixed
     */
    public function file($file)
    {
        $parameters = is_array($file)
            ? $file
            : ['file' => $file];

        // trigger_error(__METHOD__ . ': use "Selenium::uploadFile()" instead', E_USER_DEPRECATED);

        try {
            $result = $this->curl('POST', 'file', $parameters);
        } catch (\Exception $e) {
            $result = $this->selenium()->uploadFile($parameters);
        }

        return $result['value'];
    }

    /**
     * {@inheritdoc}
     */
    protected function getNewIdentifierPath($identifier)
    {
        return $this->url . "/element/$identifier";
    }
}
