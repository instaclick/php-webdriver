<?php

/**
 * @copyright 2012 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 * @author Fabrizio Branca <mail@fabrizio-branca.de>
 */

namespace WebDriver\SauceLabs;

use WebDriver\ServiceFactory;

/**
 * WebDriver\SauceLabs\SauceRest class
 *
 * @package WebDriver
 */
class SauceRest
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $accessKey;

    /**
     * Curl service
     *
     * @var \WebDriver\Service\CurlService|null
     */
    private $curlService;

    /**
     * Transient options
     *
     * @var array
     */
    private $transientOptions;

    /**
     * Constructor
     *
     * @param string $userId    Your Sauce user name
     * @param string $accessKey Your Sauce API key
     */
    public function __construct($userId, $accessKey)
    {
        $this->userId      = $userId;
        $this->accessKey   = $accessKey;
        $this->curlService = null;
    }

    /**
     * Set curl service
     *
     * @param \WebDriver\Service\CurlService $curlService
     */
    public function setCurlService($curlService)
    {
        $this->curlService = $curlService;
    }

    /**
     * Get curl service
     *
     * @return \WebDriver\Service\CurlService
     */
    public function getCurlService()
    {
        return $this->curlService ?: ServiceFactory::getInstance()->getService('service.curl');
    }

    /**
     * Set transient options
     *
     * @param mixed $transientOptions
     */
    public function setTransientOptions($transientOptions)
    {
        $this->transientOptions = is_array($transientOptions) ? $transientOptions : array();
    }

    /**
     * Execute Sauce Labs REST API command
     *
     * @param string $requestMethod HTTP request method
     * @param string $url           URL
     * @param mixed  $parameters    Parameters
     * @param array  $extraOptions  key=>value pairs of curl options to pass to curl_setopt()
     *
     * @return mixed
     *
     * @throws \WebDriver\Exception\CurlExec
     *
     * @see https://docs.saucelabs.com/secure-connections/sauce-connect/system-requirements/#rest-api-endpoints
     */
    protected function execute($requestMethod, $url, $parameters = null, $extraOptions = array())
    {
        $extraOptions = array(
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => $this->userId . ':' . $this->accessKey,

            // don't verify SSL certificates
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,

            CURLOPT_HTTPHEADER => array('Expect:'),
            CURLOPT_FAILONERROR => true,
        );

        $url = 'https://saucelabs.com/rest/v1/' . $url;

        list($rawResult, $info) = $this->curlService->execute(
            $requestMethod,
            $url,
            $parameters,
            array_replace($extraOptions, $this->transientOptions)
        );

        $this->transientOptions = array();

        return json_decode($rawResult, true);
    }

    /**
     * Get account details: /rest/v1/users/:userId (GET)
     *
     * @param string $userId
     *
     * @return array
     */
    public function getAccountDetails($userId)
    {
        return $this->execute('GET', 'users/' . $userId);
    }

    /**
     * Check account limits: /rest/v1/limits (GET)
     *
     * @return array
     */
    public function getAccountLimits()
    {
        return $this->execute('GET', 'limits');
    }

    /**
     * Create new sub-account: /rest/v1/users/:userId (POST)
     *
     * For "partners", $accountInfo also contains 'plan' => (one of 'free', 'small', 'team', 'com', or 'complus')
     *
     * @param array $accountInfo array('username' => ..., 'password' => ..., 'name' => ..., 'email' => ...)
     *
     * @return array array('access_key' => ..., 'minutes' => ..., 'id' => ...)
     */
    public function createSubAccount($accountInfo)
    {
        return $this->execute('POST', 'users/' . $this->userId, $accountInfo);
    }

    /**
     * Update sub-account service plan: /rest/v1/users/:userId/subscription (POST)
     *
     * @param string $userId User ID
     * @param string $plan   Plan
     *
     * @return array
     */
    public function updateSubAccount($userId, $plan)
    {
        return $this->execute('POST', 'users/' . $userId . '/subscription', array('plan' => $plan));
    }

    /**
     * Unsubscribe a sub-account: /rest/v1/users/:userId/subscription (DELETE)
     *
     * @param string $userId User ID
     *
     * @return array
     */
    public function unsubscribeSubAccount($userId)
    {
        return $this->execute('DELETE', 'users/' . $userId . '/subscription');
    }

    /**
     * Get current account activity: /rest/v1/:userId/activity (GET)
     *
     * @return array
     */
    public function getActivity()
    {
        return $this->execute('GET', $this->userId . '/activity');
    }

    /**
     * Get historical account usage: /rest/v1/:userId/usage (GET)
     *
     * @param string $start Optional start date YYYY-MM-DD
     * @param string $end   Optional end date YYYY-MM-DD
     *
     * @return array
     */
    public function getUsage($start = null, $end = null)
    {
        $query = http_build_query(array(
            'start' => $start,
            'end' => $end,
        ));

        return $this->execute('GET', $this->userId . '/usage' . (strlen($query) ? '?' . $query : ''));
    }

    /**
     * Get jobs: /rest/v1/:userId/jobs (GET)
     *
     * @param boolean $full
     *
     * @return array
     */
    public function getJobs($full = null)
    {
        $query = http_build_query(array(
            'full' => (isset($full) && $full) ? 'true' : null,
        ));

        return $this->execute('GET', $this->userId . '/jobs' . (strlen($query) ? '?' . $query : ''));
    }

    /**
     * Get full information for job: /rest/v1/:userId/jobs/:jobId (GET)
     *
     * @param string $jobId
     *
     * @return array
     */
    public function getJob($jobId)
    {
        return $this->execute('GET', $this->userId . '/jobs/' . $jobId);
    }

    /**
     * Update existing job: /rest/v1/:userId/jobs/:jobId (PUT)
     *
     * @param string $jobId   Job ID
     * @param array  $jobInfo Job information
     *
     * @return array
     */
    public function updateJob($jobId, $jobInfo)
    {
        return $this->execute('PUT', $this->userId . '/jobs/' . $jobId, $jobInfo);
    }

    /**
     * Stop job: /rest/v1/:userId/jobs/:jobId/stop (PUT)
     *
     * @param string $jobId
     *
     * @return array
     */
    public function stopJob($jobId)
    {
        return $this->execute('PUT', $this->userId . '/jobs/' . $jobId . '/stop');
    }

    /**
     * Delete job: /rest/v1/:userId/jobs/:jobId (DELETE)
     *
     * @param string $jobId
     *
     * @return array
     */
    public function deleteJob($jobId)
    {
        return $this->execute('DELETE', $this->userId . '/jobs/' . $jobId);
    }

    /**
     * Get running tunnels for a given user: /rest/v1/:userId/tunnels (GET)
     *
     * @return array
     */
    public function getTunnels()
    {
        return $this->execute('GET', $this->userId . '/tunnels');
    }

    /**
     * Get full information for a tunnel: /rest/v1/:userId/tunnels/:tunnelId (GET)
     *
     * @param string $tunnelId
     *
     * @return array
     */
    public function getTunnel($tunnelId)
    {
        return $this->execute('GET', $this->userId . '/tunnels/' . $tunnelId);
    }

    /**
     * Shut down a tunnel: /rest/v1/:userId/tunnels/:tunnelId (DELETE)
     *
     * @param string $tunnelId
     *
     * @return array
     */
    public function shutdownTunnel($tunnelId)
    {
        return $this->execute('DELETE', $this->userId . '/tunnels/' . $tunnelId);
    }

    /**
     * Get current status of Sauce Labs' services: /rest/v1/info/status (GET)
     *
     * @return array array('wait_time' => ..., 'service_operational' => ..., 'status_message' => ...)
     */
    public function getStatus()
    {
        return $this->execute('GET', 'info/status');
    }

    /**
     * Get currently supported browsers: /rest/v1/info/browsers (GET)
     *
     * @param string $termination Optional termination (one of "all", "selenium-rc", or "webdriver')
     *
     * @return array
     */
    public function getBrowsers($termination = '')
    {
        if ($termination) {
            return $this->execute('GET', 'info/browsers/' . $termination);
        }

        return $this->execute('GET', 'info/browsers');
    }

    /**
     * Get number of tests executed so far on Sauce Labs: /rest/v1/info/counter (GET)
     *
     * @return array
     */
    public function getCounter()
    {
        return $this->execute('GET', 'info/counter');
    }
}
