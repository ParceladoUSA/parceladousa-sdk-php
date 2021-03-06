<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace klebervmv;

use stdClass;

/**
 * Description of CurlControle
 *
 * @author klebertonvilela
 */
class EasyCurl
{
    /**
     * @var false|resource
     */
    private $curlInit;
    /**
     * @var stdClass
     */
    private $curlOpt;
    /**
     * @var
     */
    private $error;
    /**
     * @var
     */
    private $httpCode;
    /**
     * @var
     */
    private $Result;
    /**
     * @var string
     */
    private $contentType;

    /**
     * EasyCurl constructor.
     * @param string $baseUrl
     * @param bool $sslVerify
     * @param string $contentType
     */
    public function __construct($baseUrl, $sslVerify = true, $contentType = "json")
    {
        $this->curlOpt = new stdClass();
        $this->curlOpt->baseUrl = (string) $baseUrl;
        $this->curlOpt->sslFerify = (bool) $sslVerify;
        $this->contentType = (string) $contentType;
        $this->resetHeader();

        $this->curlInit = curl_init();
    }

    /**
     *
     * @param string $Method GET,POST,PUT,DELETE
     * @param string $endPoint /endpoint
     * @param  $postFields array ou stdClass, pois será convertido em um Json
     */
    public function render($Method, $endPoint, $postFields = null)
    {
        $this->curlOpt->method = (string) $Method;
        $this->curlOpt->endPoint = (string) $endPoint;
        $this->curlOpt->postField = (!empty($postFields)) ? (($this->contentType === "json") ? json_encode($postFields) : $postFields) : null;


        return $this;
    }


    /**
     *
     * @param string $header string para header no formato "chave:valor"
     * pose ser chamada diversas vezes pois o valor informado será inserido em um array
     */
    public function setHeader($header)
    {
        $this->curlOpt->header[] = (string) $header;
        return $this;
    }

    /**
     * @param string $contentType
     * @return $this
     */
    public function setContentType($contentType)
    {
        $this->contentType = (string) $contentType;
        return $this;
    }

    /**
     * @return $this
     */
    public function resetHeader()
    {
        unset($this->curlOpt->header);
        $ct = ($this->contentType === "json") ? "application/json" : (($this->contentType === "xml") ? "text/xml;charset=UTF-8" : "");
        $this->curlOpt->header[] = (!empty($ct)) ? "Content-Type:" . $ct : "";

        return $this;
    }
    /**
     * @return $this
     */
    public function prepareCurlOpt()
    {
        $this->curlOpt->baseUrl = (substr($this->curlOpt->baseUrl, -1) === "/") ? substr_replace($this->curlOpt->baseUrl, "", -1, 1) : $this->curlOpt->baseUrl;

        $separator = (substr($this->curlOpt->endPoint, 0, 1) === "/") ? "" : "/";
        $options = array(
            CURLOPT_URL => $this->curlOpt->baseUrl . $separator . $this->curlOpt->endPoint,
            CURLOPT_CUSTOMREQUEST => $this->curlOpt->method,
            CURLOPT_POSTFIELDS => $this->curlOpt->postField,
            CURLOPT_HTTPHEADER => $this->curlOpt->header,
            CURLOPT_SSL_VERIFYPEER => $this->curlOpt->sslFerify,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($this->curlInit, $options);
        return $this;
    }

    /**
     * @return $this
     */
    public function send()
    {
        $this->prepareCurlOpt();
        $responseData = curl_exec($this->curlInit);

        if (curl_errno($this->curlInit)) {
            $this->error = curl_error($this->curlInit);
            return $this;
        }

        $this->httpCode = curl_getinfo($this->curlInit)['http_code'];
        $this->Result = $responseData;

        if ($this->contentType === "json") {
            $this->jsDecode();
        }

        return $this;
    }

    /**
     *
     */
    function jsDecode()
    {
        $this->Result = json_decode($this->Result, true);
    }

    /**
     * @return int
     */
    function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * @return mixed
     */
    function getResult()
    {
        return $this->Result;
    }

    /**
     * @return string|null
     */
    function getError()
    {
        return $this->error;
    }

    /**
     * @return false|resource
     */
    public function getCurlInit()
    {
        return $this->curlInit;
    }

}
