<?php

class LCSeverity {

    const TRACE = 'trace';
    const DEBUG = 'debug';
    const INFO = 'info';
    const WARNING = 'warning';
    const ERROR = 'error';
    const FATAL = 'fatal';
}

class LCLogger {

    private $_instanceId;
    private $_url;

    function __construct($instanceId) {
        $this->_instanceId= $instanceId;
        $this->_url = 'http://localhost:9000/api/v1/instances/'. $this->_instanceId . '/messages';
    }


    public function setInstanceId($instanceId) {
        $this->_instanceId = $instanceId;
    }

    public function getInstanceId() {
        return $this->_instanceId;
    }

    public function log($severity, $text) {
        $data = array(
            "severity" => $severity,
            "text" => $text,
            "generated" => $this->generatedTime()
        );

        $this->sendMsg($data);

    }

    public function trace($text) {
        $this->log(LCSeverity::TRACE, $text);
    }

    public function debug($text) {
        $this->log(LCSeverity::DEBUG, $text);
    }

    public function info($text) {
        $this->log(LCSeverity::INFO, $text);
    }

    public function warning($text) {
        $this->log(LCSeverity::WARNING, $text);
    }

    public function error($text) {
        $this->log(LCSeverity::ERROR, $text);
    }

    public function fatal($text) {
        $this->log(LCSeverity::FATAL, $text);
    }

    private function sendMsg($data) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        curl_exec($ch);

        curl_close($ch);
    }

    private  function generatedTime() {
        return strval(round(microtime(true) * 1000));
    }

}