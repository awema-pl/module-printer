<?php

namespace AwemaPL\Printer\Sections\Printers\Models\Contracts;

interface Printer
{
    /**
     * Get the owning printable model.
     */
    public function printable();
}
