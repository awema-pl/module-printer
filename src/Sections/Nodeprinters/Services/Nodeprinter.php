<?php

namespace AwemaPL\Printer\Sections\Nodeprinters\Services;

use AwemaPL\Printer\Sections\Nodeprinters\Services\Contracts\Nodeprinter as NodeprinterContract;
use PrintNode\Credentials;
use PrintNode\Request;

class Nodeprinter implements NodeprinterContract
{

    /**
     * Request
     *
     * @param $apiKey
     * @return Request
     */
    public function request($apiKey)
    {
        $credentials = new Credentials();
        $credentials->setApiKey($apiKey);
        return new Request($credentials);
    }
}
