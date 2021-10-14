<?php

    namespace Parceladousa\Interfaces;

    interface RequestInterface
    {
        public function getRoute();

        public function getMethod();

        public function getData();

    }