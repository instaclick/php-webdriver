<?php

namespace WebDriver\Service;


final class CurlServiceException extends \Exception {
    protected $curlInfo = array();

    public function __construct($message = "", $code = 0, \Exception $previous = null, $curlInfo = array()) {
        parent::__construct($message, $code, $previous);
        $this->curlInfo = $curlInfo;
    }

    public function getCurlInfo() {
        return $this->curlInfo;
    }
}
