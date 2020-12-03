<?php

namespace AwemaPL\Printer\Sections\Printers\Scopes;

use AwemaPL\Repository\Scopes\ScopesAbstract;

class EloquentPrinterScopes extends ScopesAbstract
{
    protected $scopes = [
    'q' =>SearchPrinter::class,
    ];
}
