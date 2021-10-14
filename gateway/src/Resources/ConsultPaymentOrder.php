<?php

    namespace Parceladousa\Resources;

    use Parceladousa\Interfaces\RequestInterface;

    class ConsultPaymentOrder implements RequestInterface
    {
        private $orderId;

        public function __construct($orderId)
        {
            $this->orderId = $orderId;
        }

        /**
         * @return string
         */
        public function getRoute()
        {
            return "order/$this->orderId";
        }

        /**
         * @return string
         */
        public function getMethod()
        {
            return "GET";
        }

        /**
         * @return object|null
         */
        public function getData()
        {
            return null;
        }
    }