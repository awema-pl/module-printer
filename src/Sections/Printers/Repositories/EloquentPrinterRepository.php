<?php

namespace AwemaPL\Printer\Sections\Printers\Repositories;

use AwemaPL\Printer\Sections\Printers\Models\Printer;
use AwemaPL\Printer\Sections\Printers\Repositories\Contracts\PrinterRepository;
use AwemaPL\Printer\Sections\Printers\Scopes\EloquentPrinterScopes;
use AwemaPL\Repository\Eloquent\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EloquentPrinterRepository extends BaseRepository implements PrinterRepository
{
    protected $searchable = [

    ];

    public function entity()
    {
        return Printer::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new EloquentPrinterScopes($request))->scope($this->entity);
        $this->with('printable');
        return $this;
    }

}
