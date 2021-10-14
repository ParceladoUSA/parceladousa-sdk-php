<?php

    namespace Parceladousa\Resources;

    use klebervmv\EasyCurl;

    abstract class StartParceladoUSA
    {
        const ENDPOINT_SANDBOX = 'https://apisandbox.parceladousa.com/v1/paymentapi';
        const ENDPOINT_PRODUCTION = 'https://api.parceladousa.com/v1/paymentapi';
        const SANDBOX = 'sandbox';
        const PRODUCTION = 'production';
        const BRAZILIANCURRENCY = 'BRL';
        const AMERICANCURRENCY = 'USD';

        protected $easyCurl;
        private $apiUrl;

        public function __construct($environment)
        {
            $this->apiUrl = ($environment === self::SANDBOX) ? self::ENDPOINT_SANDBOX : self::ENDPOINT_PRODUCTION;
            $this->easyCurl = new EasyCurl($this->apiUrl);
        }

    }