<?php

    namespace Parceladousa\Resources;

    use Parceladousa\Interfaces\RequestInterface;
    use stdClass;

    class CalculateValues implements RequestInterface
    {
        private $amount;

        /**
         * @param float $amount
         * @return $this
         */
        public function setAmount($amount)
        {
            $this->amount = $amount;
            return $this;
        }


        public function getRoute()
        {
            return "calculate";
        }

        public function getMethod()
        {
            return "POST";
        }

        public function getData()
        {
            $data = new stdClass();
            $data->amount = $this->amount;
            return (object)$data;
        }
    }