<?php

namespace AwemaPL\Printer\Sections\Nodeprinters\Services;

use AwemaPL\Printer\Exceptions\PrinterApiException;
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
     * @throws PrinterApiException
     */
    public function request($apiKey)
    {
        $credentials = new Credentials();
        $credentials->setApiKey($apiKey);
        return new PrintnodeRequest($credentials);
    }

}
