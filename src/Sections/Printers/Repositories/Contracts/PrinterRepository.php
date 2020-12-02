<?php

namespace AwemaPL\Printer\Sections\Printers\Repositories\Contracts;

use Illuminate\Http\Request;

interface PrinterRepository
{

    /**
     * Scope printer
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function scope($request);

}
