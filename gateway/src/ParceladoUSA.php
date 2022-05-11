<?php

    namespace Parceladousa;

    use Parceladousa\Interfaces\RequestInterface;
    use Parceladousa\Resources\CalculateValues;
    use Parceladousa\Resources\ConsultPaymentOrder;
    use Parceladousa\Resources\RequestPaymentOrder;
    use Parceladousa\Resources\StartParceladoUSA;

    class ParceladoUSA extends StartParceladoUSA
    {
        private $fail;
        private $pubKey;
        private $merchantCode;
        private $result;
        private $msg;
        private $callback;

        public function __construct($pubKey, $merchantCode, $environment, $callback)
        {
            parent::__construct($environment);
            $this->fail = false;
            $this->msg = '';
            $this->pubKey = (string) $pubKey;
            $this->merchantCode = (string) $merchantCode;
            $this->callback = (string) $callback;
        }

        /**
         * @param string $orderId
         * @return $this
         */
        public function consultPaymentOrder($orderId)
        {
            return $this->send(new ConsultPaymentOrder((string) $orderId));
        }

        /**
         * @param object $data
         * @return $this
         */
        public function requestPaymentOrder($data)
        {
            $request = new RequestPaymentOrder();
            $request->setAmount($data->amount);
            $request->setInvoice($data->invoice);
            $request->setCurrency($data->currency);
            $request->setName($data->name);
            $request->setEmail($data->email);
            $request->setPhone($data->phone);
            $request->setDocument($data->doc);
            $request->setCep($data->cep);
            $request->setAddress($data->address);
            $request->setAddressNumber($data->addressNumber);
            $request->setCity($data->city);
            $request->setState($data->state);
            $request->setCallback($this->callback);
            return $this->send($request);
        }

        /**
         * @param object $data
         * @return $this|null
         */
        public function calculateValues($data)
        {
            $request = new CalculateValues();
            $request->setAmount($data->amount);
            return $this->send($request);
        }

        /**
         * @return object|null
         */
        private function requestAuth()
        {
            $data = array(
                'pubKey' => $this->pubKey,
                'merchantCode' => $this->merchantCode
            );

            $request = $this->easyCurl->render('POST', '/auth', $data)->send();

            if ($request->getHttpCode() !== 200) {
                return null;
            }

            return $request->getResult();
        }

        /**
         * @param RequestInterface $requestInterface
         * @return $this|null
         */
        private function send(RequestInterface $requestInterface)
        {
            if (!$token = $this->requestAuth()['token']) {
                $this->fail = true;
                return null;
            }

            $request = $this->easyCurl->resetHeader()
                ->setHeader("Authorization:Bearer " . $token)
                ->render($requestInterface->getMethod(), $requestInterface->getRoute(), $requestInterface->getData())
                ->send();
            $this->result = $request->getResult();
            return $this;
        }

        /**
         * @return false
         */
        public function fail()
        {
            return $this->fail;
        }

        /**
         * @return string
         */
        public function getMsg()
        {
            return $this->msg;
        }

        /**
         * @return object
         */
        public function getResult()
        {
            return (object)$this->result;
        }


    }