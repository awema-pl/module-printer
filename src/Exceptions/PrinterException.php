<?php
namespace AwemaPL\Printer\Exceptions;
use Exception;

class PrinterException extends Exception
{
    protected $errorCode;

    public function __construct($message = '', $errorCode = '', Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->errorCode = $errorCode;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }
}
