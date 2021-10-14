<?php

    namespace Parceladousa\Resources;

    use Parceladousa\Interfaces\RequestInterface;
    use Parceladousa\ParceladoUSA;
    use stdClass;

    class RequestPaymentOrder implements RequestInterface
    {
        private $amount;
        private $currency;
        private $name;
        private $email;
        private $phone;
        private $document;
        private $cep;
        private $address;
        private $addressNumber;
        private $city;
        private $state;

        /**
         * @param float $amount
         * @return $this
         */
        public function setAmount($amount)
        {
            $this->amount = (float) $amount;
            return $this;
        }

        /**
         * @param string $currency
         * @return $this
         */
        public function setCurrency($currency = ParceladoUSA::AMERICANCURRENCY )
        {
            $this->currency = (string) $currency;
            return $this;
        }

        /**
         * @param string|null $name
         * @return $this
         */
        public function setName($name = '' )
        {
            $this->name = (string) $name;
            return $this;
        }

        /**
         * @param string|null $email
         * @return $this
         */
        public function setEmail($email = '' )
        {
            $this->email = (string) $email;
            return $this;
        }

        /**
         * @param string|null $phone
         * @return $this
         */
        public function setPhone($phone = '' )
        {
            $this->phone = (string) $phone;
            return $this;
        }

        /**
         * @param string|null $document
         * @return $this
         */
        public function setDocument($document = '' )
        {
            $this->document = (string) $document;
            return $this;
        }

        /**
         * @param string|null $cep
         * @return $this
         */
        public function setCep($cep = '' )
        {
            $this->cep = (string) $cep;
            return $this;
        }

        /**
         * @param string|null $address
         * @return $this
         */
        public function setAddress($address = '' )
        {
            $this->address = (string) $address;
            return $this;
        }

        /**
         * @param string|null $addressNumber
         * @return $this
         */
        public function setAddressNumber($addressNumber = '' )
        {
            $this->addressNumber = (string) $addressNumber;
            return $this;
        }

        /**
         * @param string|null $city
         * @return $this
         */
        public function setCity($city = '' )
        {
            $this->city = (string) $city;
            return $this;
        }

        /**
         * @param string|null $state
         * @return $this
         */
        public function setState($state = '' )
        {
            $this->state = (string) $state;
            return $this;
        }

        /**
         * @param string $callback
         * @return $this
         */
        public function setCallback($callback)
        {
            $this->callback = (string) $callback;
            return $this;
        }

        public function getRoute()
        {
            return "order";
        }

        /**
         * @return string
         */
        public function getMethod()
        {
            return "POST";
        }

        public function getData()
        {
            $data = new stdClass();
            $data->amount = $this->amount;
            $data->currency = $this->currency;
            $data->client = new stdClass();
            $data->client->name = $this->name;
            $data->client->email = $this->email;
            $data->client->phone = $this->phone;
            $data->client->doc = $this->document;
            $data->client->cep = $this->cep;
            $data->client->address = $this->address;
            $data->client->addressNumber = $this->addressNumber;
            $data->client->city = $this->city;
            $data->client->state = $this->state;
            $data->callback = $this->callback;
            return (object) $data;
        }
    }