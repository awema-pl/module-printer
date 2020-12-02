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
}
