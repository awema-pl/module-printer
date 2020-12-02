<?php

namespace AwemaPL\Printer\Sections\Nodeprinters\Repositories;

use AwemaPL\Printer\Sections\Nodeprinters\Models\Nodeprinter;
use AwemaPL\Printer\Sections\Nodeprinters\Repositories\Contracts\NodeprinterRepository;
use AwemaPL\Printer\Sections\Nodeprinters\Scopes\EloquentNodeprinterScopes;
use AwemaPL\Printer\Sections\Printers\Exceptions\PrinterException;
use AwemaPL\Printer\Sections\Printers\Repositories\Contracts\PrinterRepository;
use AwemaPL\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Auth;
use AwemaPL\Printer\Sections\Nodeprinters\Services\Contracts\Nodeprinter as NodeprinterService;
use PrintNode\Printer;
use PrintNode\Whoami;

class EloquentNodeprinterRepository extends BaseRepository implements NodeprinterRepository
{

    /** @var PrinterRepository $printers */
    protected $printers;

    /** @var NodeprinterService */
    protected $nodeprinter;

    public function __construct(PrinterRepository $printers, NodeprinterService $nodeprinter)
    {
        parent::__construct();
        $this->printers = $printers;
        $this->nodeprinter = $nodeprinter;
    }

    protected $searchable = [

    ];

    public function entity()
    {
        return Nodeprinter::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new EloquentNodeprinterScopes($request))->scope($this->entity);
        return $this;
    }

    /**
     * Create new role
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $data['user_id'] = $data['user_id'] ?? Auth::id();
        $data = array_merge($data, $this->printerData($data['api_key'], $data['printer_id']));
        $nodeprinter = Nodeprinter::create($data);
        $nodeprinter->printer()->create([
            'user_id' =>$data['user_id'],
        ]);
        return $nodeprinter;
    }

    /**
     * Update printer
     *
     * @param array $data
     * @param int $id
     * @param string $attribute
     *
     * @return int
     */
    public function update(array $data, $id, $attribute = 'id')
    {
        $data = array_merge($data, $this->printerData($data['api_key'], $data['printer_id']));
        return parent::update($data, $id, $attribute);
    }

    /**
     * Delete printer
     *
     * @param int $id
     */
    public function delete($id){
        $nodeprinter = Nodeprinter::find($id);
        $nodeprinter->printer()->delete();
        $this->destroy($id);
    }

    /**
     * Select nodeprinter
     *
     * @param string $apiKey
     */
    public function select($apiKey)
    {
        $request = $this->nodeprinter->request($apiKey);
        $printers = [];

        /** @var Printer $printer */
        foreach ($request->getPrinters() ?? [] as $printer){

            $nameComputer = $printer->computer->name;
            $namePrinter = $printer->name;
            $idPrinter = $printer->id;
            array_push($printers, [
                'id' =>$idPrinter,
                'name' =>"$nameComputer/$namePrinter"
            ]);
        }
        return $printers;
    }

    /**
     * Printer data
     *
     * @param $apiKey
     * @param $printerId
     * @return array
     */
    private function printerData($apiKey, $printerId)
    {
        $request = $this->nodeprinter->request($apiKey);
        $printers = $request->getPrinters();
        /** @var Whoami $whoami */
        $whoami = $request->getWhoami();
        /** @var Printer $printer */
      foreach ($printers as $printer){
          if ((int)$printerId === $printer->id){
              return [
                  'email' => $whoami->email,
                  'location' =>sprintf('%s/%s', $printer->computer->name, $printer->name),
              ];
          }
      }
      throw new PrinterException('Not found printer.');
    }
}
