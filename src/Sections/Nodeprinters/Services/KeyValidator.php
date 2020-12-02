<?php

namespace AwemaPL\Printer\Sections\Nodeprinters\Services;

use Exception;
use PrintNode\Credentials;
use PrintNode\Request;

class KeyValidator
{
    /**
     * Is valid API key
     * @param $apiKey
     * @return bool
     */
    public static function isValidApiKey($apiKey){
        try {
            $request = (new Nodeprinter())->request($apiKey);
            $request->getPrintJobStates();
            return true;
        } catch (Exception $e){
            return false;
        }
    }
}
