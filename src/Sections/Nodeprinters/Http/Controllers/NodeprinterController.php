<?php

namespace AwemaPL\Printer\Sections\Nodeprinters\Http\Controllers;

use AwemaPL\Printer\Sections\Nodeprinters\Http\Requests\SelectNodeprinter;
use AwemaPL\Printer\Sections\Nodeprinters\Http\Requests\StoreNodeprinter;
use AwemaPL\Printer\Sections\Nodeprinters\Http\Requests\UpdateNodeprinter;
use AwemaPL\Printer\Sections\Nodeprinters\Models\Nodeprinter;
use AwemaPL\Printer\Sections\Nodeprinters\Repositories\Contracts\NodeprinterRepository;
use AwemaPL\Printer\Sections\Nodeprinters\Resources\EloquentNodeprinter;
use AwemaPL\Auth\Controllers\Traits\RedirectsTo;
use AwemaPL\Printer\Sections\Nodeprinters\Services\KeyValidator;
use AwemaPL\Printer\Sections\Printers\Exceptions\PrinterException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NodeprinterController extends Controller
{

    use RedirectsTo, AuthorizesRequests;

    /**
     * Nodeprinters repository instance
     *
     * @var NodeprinterRepository
     */
    protected $nodeprinters;

    public function __construct(NodeprinterRepository $nodeprinters)
    {
        $this->nodeprinters = $nodeprinters;
    }

    /**
     * Display nodeprinters
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('printer::sections.nodeprinters.index');
    }

    /**
     * Request scope
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function scope(Request $request)
    {
        return EloquentNodeprinter::collection(
            $this->nodeprinters->scope($request)
                ->isOwner()
                ->latest()->smartPaginate()
        );
    }

    /**
     * Add nodeprinter
     *
     * @param StoreNodeprinter $request
     * @return array
     * @throws \Exception
     */
    public function store(StoreNodeprinter $request)
    {
        $this->nodeprinters->create($request->all());
        return notify(_p('printer::notifies.nodeprinter.success_added_printer', 'Success added printer.'));
    }

    /**
     * Select nodeprinter
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function select(Request $request)
    {
        if (!KeyValidator::isValidApiKey($request->api_key)){
            throw new PrinterException(_p('printer::notifies.nodeprinter.invalid_api_key', 'Invalid API key.'));
        }
        return $this->ajax($this->nodeprinters->select($request->api_key));
    }

    /**
     * Update nodeprinter
     *
     * @param UpdateNodeprinter $request
     * @param $id
     * @return array
     */
    public function update(UpdateNodeprinter $request, $id)
    {
        $this->authorize('isOwner', Nodeprinter::find($id));
        $this->nodeprinters->update($request->all(), $id);
        return notify(_p('printer::notifies.nodeprinter.success_updated_printer', 'Success updated printer.'));
    }
    
    /**
     * Destroy nodeprinter
     *
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        $this->authorize('isOwner', Nodeprinter::find($id));
        $this->nodeprinters->delete($id);
        return notify(_p('printer::notifies.nodeprinter.success_deleted_printer', 'Success deleted printer.'));
    }

}
