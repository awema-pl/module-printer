<?php

namespace AwemaPL\Printer\Sections\Nodeprinters\Services;

use AwemaPL\Printer\Sections\Nodeprinters\Services\Contracts\Nodeprinter as NodeprinterContract;
use Exception;
use PrintNode\Credentials;
use PrintNode\PrintJob;
use PrintNode\Request;

class Nodeprinter implements NodeprinterContract
{

    /**
     * Request
     *
     * @param $apiKey
     * @return Request
     * @throws Exception
     */
    public function request($apiKey)
    {
        $credentials = new Credentials();
        $credentials->setApiKey($apiKey);
        return new Request($credentials);
    }

}
