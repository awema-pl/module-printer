<?php

namespace AwemaPL\Printer\Sections\Printers\Http\Controllers;

use AwemaPL\Auth\Controllers\Traits\RedirectsTo;
use AwemaPL\Printer\Sections\Printers\Repositories\Contracts\PrinterRepository;
use AwemaPL\Printer\Sections\Printers\Resources\EloquentPrinter;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PrinterController extends Controller
{

    use RedirectsTo, AuthorizesRequests;

    /**
     * Printers repository instance
     *
     * @var PrinterRepository
     */
    protected $printers;

    public function __construct(PrinterRepository $printers)
    {
        $this->printers = $printers;
    }

    /**
     * Display printers
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('printer::sections.printers.index');
    }

    /**
     * Request scope
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function scope(Request $request)
    {
        return EloquentPrinter::collection(
            $this->printers->scope($request)
                ->isOwner()
                ->latest()->smartPaginate()
        );
    }
}
