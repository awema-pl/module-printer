<?php

namespace AwemaPL\Printer\Sections\Nodeprinters\Services\Contracts;
use AwemaPL\Printer\Sections\Nodeprinters\Services\Validators\Validator;
use PrintNode\Request;

interface Nodeprinter
{
    /**
     * Request
     *
     * @param $apiKey
     * @return Request
     */
    public function request($apiKey);
}
