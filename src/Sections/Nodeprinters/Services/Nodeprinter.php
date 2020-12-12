<?php

namespace AwemaPL\Printer\Sections\Nodeprinters\Services;

use AwemaPL\Printer\Exceptions\PrinterException;
use AwemaPL\Printer\Sections\Nodeprinters\Services\Contracts\Nodeprinter as NodeprinterContract;
use Exception;
use PrintNode\Credentials;
use PrintNode\PrintJob;

class Nodeprinter implements NodeprinterContract
{

    /**
     * Request
     *
     * @param $apiKey
     * @return PrintnodeRequest
     * @throws PrinterException
     */
    public function request($apiKey)
    {
        $credentials = new Credentials();
        $credentials->setApiKey($apiKey);
        return new PrintnodeRequest($credentials);
    }

}
