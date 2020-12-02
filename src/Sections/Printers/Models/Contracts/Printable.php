<?php

namespace AwemaPL\Printer\Sections\Printers\Models\Contracts;

interface Printable
{

    /**
     * Get provider name
     *
     * @return string
     */
    public function getProviderName();

    /**
     * Print pdf
     *
     * @param $originalContent
     * @param array $options
     * @return mixed
     */
    public function printPdf($originalContent, $options = []);
}
