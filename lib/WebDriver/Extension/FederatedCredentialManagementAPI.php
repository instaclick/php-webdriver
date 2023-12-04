<?php

/**
 * @copyright 2023 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver\Extension;

use WebDriver\AbstractWebDriver;

/**
 * Federated Credential Management API extensions
 *
 * @see https://fedidcg.github.io/FedCM/#automation
 *
 * @package WebDriver
 *
 * @method array canceldialog() Cancel dialog.
 * @method array clickdialogbutton() Click dialog button.
 * @method array selectaccount() Select account.
 * @method array accountlist() Get accounts.
 * @method array gettitle() Get FedCM title.
 * @method array getdialogtype() Get FedCM dialog type.
 * @method array setdelayenabled() Set delay enabled.
 */
class FederatedCredentialManagementAPI extends AbstractWebDriver
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return [
            'canceldialog'      => ['POST'],
            'clickdialogbutton' => ['POST'],
            'selectaccount'     => ['POST'],
            'accountlist'       => ['GET'],
            'gettitle'          => ['GET'],
            'getdialogtype'     => ['GET'],
            'setdelayenabled'   => ['POST'],
        ];
    }

    /**
     * Cancel Dialog: /session/:sessionId/fedcm/canceldialog (POST)
     *
     * @return mixed
     */
    public function cancelDialog()
    {
        $result = $this->curl('POST', '/canceldialog');

        return $result['value'];
    }

    /**
     * Select Account: /session/:sessionId/fedcm/selectaccount (POST)
     *
     * @param mixed $parameters Parameters {accountIndex: ...}
     *
     * @return mixed
     */
    public function selectAccount($parameters)
    {
        if (is_integer($parameters)) {
            $parameters = ['accountIndex' => $parameters];
        }

        $result = $this->curl('POST', '/selectaccount', $parameters);

        return $result['value'];
    }

    /**
     * Click Dialog Button: /session/:sessionId/fedcm/clickdialogbutton (POST)
     *
     * @param array $parameters Parameters {dialogButton: ...}
     *
     * @return mixed
     */
    public function clickDialogButton($parameters)
    {
        $result = $this->curl('POST', '/clickdialogbutton', $parameters);

        return $result['value'];
    }

    /**
     * Get Accounts: /session/:sessionId/fedcm/accountlist (GET)
     *
     * @return mixed
     */
    public function getAccounts()
    {
        $result = $this->curl('GET', '/accountlist');

        return $result['value'];
    }

    /**
     * Get FedCM Title: /session/:sessionId/fedcm/gettitle (GET)
     *
     * @return mixed
     */
    public function getTitle()
    {
        $result = $this->curl('GET', '/gettitle');

        return $result['value'];
    }

    /**
     * Get FedCM Dialog Type: /session/:sessionId/fedcm/getdialogtype (GET)
     *
     * @return mixed
     */
    public function getDialogType()
    {
        $result = $this->curl('GET', '/getdialogtype');

        return $result['value'];
    }

    /**
     * Set Delay Enabled: /session/:sessionId/fedcm/setdelayenabled (POST)
     *
     * @param mixed $parameters Parameters {enabled: ...}
     *
     * @return mixed
     */
    public function setDelayEnabled($parameters)
    {
        if (is_bool($parameters)) {
            $parameters = ['enabled' => $parameters];
        }

        $result = $this->curl('POST', '/setdelayenabled', $parameters);

        return $result['value'];
    }

    /**
     * Reset Cooldown: /session/:sessionId/fedcm/resetCooldown (POST)
     *
     * @return mixed
     */
    public function resetCooldown()
    {
        $result = $this->curl('POST', '/resetCooldown');

        return $result['value'];
    }
}
