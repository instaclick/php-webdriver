<?php

/**
 * @copyright 2004 Meta Platforms, Inc.
 * @license Apache-2.0
 *
 * @author Justin Bishop <jubishop@gmail.com>
 */

namespace WebDriver;

/**
 * WebDriver\Session class
 *
 * @method void accept_alert() Accepts the currently displayed alert dialog.
 * @method array deleteActions() Release actions.
 * @method array postActions($parameters) Perform actions.
 * @method string getAlert_text() Gets the text of the currently displayed JavaScript alert(), confirm(), or prompt() dialog.
 * @method void postAlert_text($parameters) Sends keystrokes to a JavaScript prompt() dialog.
 * @method void back() Navigates backward in the browser history, if possible.
 * @method boolean getBrowser_connection() Is browser online?
 * @method void postBrowser_connection($parameters) Set browser online.
 * @method void buttondown() Click and hold the left mouse button (at the coordinates set by the last moveto command).
 * @method void buttonup() Releases the mouse button previously held (where the mouse is currently at).
 * @method void click($parameters) Click any mouse button (at the coordinates set by the last moveto command).
 * @method array getCookie() Retrieve all cookies visible to the current page.
 * @method array postCookie($parameters) Set a cookie.
 * @method void dismiss_alert() Dismisses the currently displayed alert dialog.
 * @method void doubleclick() Double-clicks at the current mouse coordinates (set by moveto).
 * @method array execute_sql($parameters) Execute SQL.
 * @method array file($parameters) Upload file.
 * @method void forward() Navigates forward in the browser history, if possible.
 * @method void keys($parameters) Send a sequence of key strokes to the active element.
 * @method array getLocation() Get the current geo location.
 * @method void postLocation($parameters) Set the current geo location.
 * @method void moveto($parameters) Move the mouse by an offset of the specified element (or current mouse cursor).
 * @method string getOrientation() Get the current browser orientation.
 * @method void postOrientation($parameters) Set the current browser orientation.
 * @method array print() Print page.
 * @method void refresh() Refresh the current page.
 * @method string screenshot() Take a screenshot of the current page.
 * @method string source() Get the current page source.
 * @method string title() Get the current page title.
 * @method string url() Retrieve the URL of the current page.
 * @method void postUrl($parameters) Navigate to a new URL.
 * @method string window_handle() Retrieve the current window handle.
 * @method array window_handles() Retrieve the list of all window handles available to the session.
 */
class Session extends Container
{
    /**
     * @var array
     */
    private $capabilities = null;

    /**
     * @var boolean
     */
    private $w3c = null;

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

            // deprecated
            'accept_alert'       => ['POST'],
            'alert_text'         => ['GET', 'POST'],
            'browser_connection' => ['GET', 'POST'],
            'buttondown'         => ['POST'],
            'buttonup'           => ['POST'],
            'click'              => ['POST'],
            'context'            => ['GET', 'POST'],
            'contexts'           => ['GET'],
            'dismiss_alert'      => ['POST'],
            'doubleclick'        => ['POST'],
            'execute_sql'        => ['POST'],
            'file'               => ['POST'],
            'keys'               => ['POST'],
            'location'           => ['GET', 'POST'],
            'moveto'             => ['POST'],
            'network_connection' => ['GET', 'POST'],
            'orientation'        => ['GET', 'POST'],
            'rotation'           => ['GET', 'POST'],
            'window_handle'      => ['GET'], // see also getWindowHandle()
            'window_handles'     => ['GET'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function obsoleteMethods()
    {
        return [
            'alert'    => ['GET'],
            'modifier' => ['POST'],
            'speed'    => ['GET', 'POST'],
            'visible'  => ['GET', 'POST'],
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
     * @param string     $url URL to server
     * @param array|null $capabilities
     */
    public function __construct($url, $capabilities)
    {
        parent::__construct($url);

        $this->capabilities = $capabilities;
        $this->w3c          = !! $capabilities;
    }

    /**
     * Is W3C webdriver?
     *
     * @return boolean
     */
    public function isW3C()
    {
        return $this->w3c;
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
        $this->curl('POST', '/url', ['url' => $url]);

        return $this;
    }

    /**
     * Get browser capabilities: /session/:sessionId (GET)
     *
     * @return mixed
     */
    public function capabilities()
    {
        if ($this->capabilities === null) {
            $result = $this->curl('GET', '');

            $this->capabilities = $result['value'];
        }

        return $this->capabilities;
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
        $result = $this->curl('GET', '/cookie');

        return $result['value'];
    }

    /**
     * Set cookie: /session/:sessionId/cookie (POST)
     * Alternative to: $session->cookie($parameters);
     *
     * @param array $parameters
     *
     * @return \WebDriver\Session
     */
    public function setCookie($parameters)
    {
        $this->curl('POST', '/cookie', ['cookie' => $parameters]);

        return $this;
    }

    /**
     * Delete all cookies: /session/:sessionId/cookie (DELETE)
     *
     * @return \WebDriver\Session
     */
    public function deleteAllCookies()
    {
        $this->curl('DELETE', '/cookie');

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
        $this->curl('DELETE', '/cookie/' . $cookieName);

        return $this;
    }

    /**
     * Get window handle: /session/:sessionId/window (GET)
     *                  : /session/:sessionId/window_handle (GET)
     * - $session->getWindowHandle()
     *
     * An alternative to $session->window()->getHandle()
     *
     * @return mixed
     */
    public function getWindowHandle()
    {
        $result = $this->curl('GET', $this->w3c ? '/window' : '/window_handle');

        return $result['value'];
    }

    /**
     * New window: /session/:sessionId/window/new (POST)
     * - $session->newWindow($type)
     *
     * @internal "new" is a reserved keyword in PHP, so $session->window()->new() isn't possible
     *
     * @return \WebDriver\Window
     */
    public function newWindow($type)
    {
        $arg = func_get_arg(0); // json

        $result = $this->curl('POST', '/window/new', $arg);

        return $result['value'];
    }

    /**
     * window method chaining: /session/:sessionId/window (POST
     * - $session->window($parameters) - set focus
     * - $session->window($handle)->method() - chaining
     * - $session->window()->method() - chaining
     *
     * @return \WebDriver\Session|\WebDriver\Window|\WebDriver\LegacyWindow
     */
    public function window()
    {
        $arg = null;

        // set window focus / switch to window
        if (func_num_args() === 1) {
            $arg = func_get_arg(0); // window handle or name attribute

            if (is_array($arg)) {
                $this->curl('POST', '/window', $arg);

                return $this;
            }
        }

        // chaining (with optional handle in $arg)
        return $this->w3c ? new Window($this->url . '/window', $arg) : new LegacyWindow($this->url . '/window', $arg);
    }

    /**
     * Close window: /session/:sessionId/window (DELETE)
     *
     * @return \WebDriver\Session
     */
    public function deleteWindow()
    {
        $this->curl('DELETE', '/window');

        return $this;
    }

    /**
     * Set focus to window: /session/:sessionId/window (POST)
     *
     * @param mixed $handle window handle (or legacy name) attribute
     *
     * @return \WebDriver\Session
     */
    public function focusWindow($handle)
    {
        $this->curl('POST', '/window', ['handle' => $handle, 'name' => $handle]);

        return $this;
    }

    /**
     * frame methods: /session/:sessionId/frame (POST)
     * - $session->frame($parameters) - change focus to another frame on the page
     * - $session->frame()->method() - chaining
     *
     * @return \WebDriver\Session|\WebDriver\Frame
     */
    public function frame()
    {
        if (func_num_args() === 1) {
            $arg = $this->serializeArguments(func_get_arg(0)); // json

            $this->curl('POST', '/frame', $arg);

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
        // set timeouts
        if (func_num_args() === 1) {
            $arg = func_get_arg(0); // json

            $this->curl('POST', '/timeouts', $arg);

            return $this;
        }

        if (func_num_args() === 2) {
            $type    = func_get_arg(0); // 'script', 'implicit', or 'pageLoad' (legacy: 'pageLoad')
            $timeout = func_get_arg(1); // timeout in milliseconds

            $arg = $this->w3c ? [$type => $timeout] : ['type' => $type, 'ms' => $timeout];

            $this->curl('POST', '/timeouts', $arg);

            return $this;
        }

        // chaining
        return new Timeouts($this->url . '/timeouts');
    }

    /**
     * Get timeouts (W3C): /session/:sessionId/timeouts (GET)
     * - $session->getTimeouts()
     *
     * @return mixed
     */
    public function getTimeouts()
    {
        $result = $this->curl('GET', '/timeouts');

        return $result['value'];
    }

    /**
     * ime method chaining, e.g.,
     * - $session->ime()->method()
     *
     * @return \WebDriver\Ime
     */
    public function ime()
    {
        return new Ime($this->url . '/ime');
    }

    /**
     * Get active element (i.e., has focus): /session/:sessionId/element/active (POST)
     * - $session->activeElement()
     *
     * @return mixed
     */
    public function activeElement()
    {
        $result = $this->curl('POST', '/element/active');

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
     * touch method chaining, e.g.,
     * - $session->touch()->method()
     *
     * @return \WebDriver\Touch
     *
     */
    public function touch()
    {
        return new Touch($this->url . '/touch');
    }

    /**
     * local_storage method chaining, e.g.,
     * - $session->local_storage()->method()
     *
     * @return \WebDriver\Storage\Local
     */
    public function localStorage()
    {
        return new Storage\Local($this->url . '/local_storage');
    }

    /**
     * session_storage method chaining, e.g.,
     * - $session->session_storage()->method()
     *
     * @return \WebDriver\Storage\Session
     */
    public function sessionStorage()
    {
        return new Storage\Session($this->url . '/session_storage');
    }

    /**
     * application cache chaining, e.g.,
     * - $session->application_cache()->method() - chaining
     *
     * @return \WebDriver\ApplicationCache
     */
    public function applicationCache()
    {
        return new ApplicationCache($this->url . '/application_cache');
    }

    /**
     * log methods: /session/:sessionId/log (POST)
     * - $session->log($type) - get log for given log type
     * - $session->log()->method() - chaining
     *
     * @return mixed
     */
    public function log()
    {
        // get log for given log type
        if (func_num_args() === 1) {
            $arg = func_get_arg(0);

            if (is_string($arg)) {
                $arg = [
                    'type' => $arg,
                ];
            }

            $result = $this->curl('POST', '/log', $arg);

            return $result['value'];
        }

        // chaining
        return new Log($this->url . '/log');
    }

    /**
     * alert method chaining, e.g.,
     * - $session->alert()->method() - chaining
     *
     * @return mixed
     */
    public function alert()
    {
        return new Alert($this->url . '/alert');
    }

    /**
     * script execution method chaining, e.g.,
     * - $session->execute($jparameters) - fallback for legacy JSON Wire Protocol
     * - $session->execute()->method() - chaining
     *
     * @return mixed
     */
    public function execute()
    {
        // execute script
        if (func_num_args() > 0) {
            $execute = $this->w3c ? new Execute($this->url . '/execute') : new LegacyExecute($this->url);
            $result  = $execute->sync(func_get_arg(0));

            return $result;
        }

        // W3C method chaining
        return new Execute($this->url . '/execute');
    }

    /**
     * async script execution
     * - $session->execute_async($parameters)
     *
     * @return mixed
     */
    public function executeAsync()
    {
        $execute = $this->w3c ? new Execute($this->url . '/execute') : new LegacyExecute($this->url);
        $result  = $execute->async(func_get_arg(0));

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function __call($name, $arguments)
    {
        $map = [
            'application_cache' => 'applicationCache',
            'execute_async'     => 'executeAsync',
            'local_storage'     => 'localStorage',
            'session_storage'   => 'sessionStorage',
        ];

        if (array_key_exists($name, $map)) {
            return call_user_func_array([$this, $map[$name]], $arguments);
        }

        // fallback to executing WebDriver commands
        return parent::__call($name, $arguments);
    }

    /**
     * {@inheritdoc}
     */
    protected function getIdentifierPath($identifier)
    {
        return $this->url . '/element/' . $identifier;
    }
}
