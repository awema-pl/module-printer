<?php

namespace AwemaPL\Printer\Sections\Nodeprinters\Services\Contracts;
use Exception;
use PrintNode\Request;

interface Nodeprinter
{
    /**
     * Request
     *
     * @param $apiKey
     * @return Request
     * @throws Exception
     */
    public function request($apiKey);

}
