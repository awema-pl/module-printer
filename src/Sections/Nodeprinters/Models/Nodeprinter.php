<?php

namespace AwemaPL\Printer\Sections\Nodeprinters\Models;

use AwemaPL\Printer\Sections\Printers\Models\Contracts\Printable;
use AwemaPL\Printer\Sections\Printers\Models\Printer;
use betterapp\LaravelDbEncrypter\Traits\EncryptableDbAttribute;
use Illuminate\Database\Eloquent\Model;
use AwemaPL\Printer\Sections\Nodeprinters\Models\Contracts\Nodeprinter as NodeprinterContract;
use AwemaPL\Printer\Sections\Nodeprinters\Services\Nodeprinter as NodeprinterService;
use Illuminate\Support\Facades\Storage;
use AwemaPL\Printer\PrintNode\PrintJob;

class Nodeprinter extends Model implements NodeprinterContract, Printable
{

    const PROVIDER_NAME = 'PrintNode';

    use EncryptableDbAttribute;

    /** @var array The attributes that should be encrypted/decrypted */
    protected $encryptable = [
        'api_key',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'api_key', 'printer_id', 'user_id', 'location'];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('printer.database.tables.printer_nodeprinters');
    }

    /**
     * Get the printer.
     */
    public function printer()
    {
        return $this->morphOne(Printer::class, 'printable');
    }

    /**
     * Get provider name
     *
     * @return string
     */
    public function getProviderName()
    {
        return self::PROVIDER_NAME;
    }

    /**
     * Print pdf
     *
     * @param $originalContent
     * @param array $options
     * @return mixed
     * @throws \Exception
     */
    public function printPdf($originalContent, $options = [])
    {
        $service = new NodeprinterService();
        $request = $service->request($this->api_key);
        $printJob = new PrintJob();
        $printJob->printer = $this->printer_id;
        $printJob->contentType = 'pdf_base64';
        $printJob->content = base64_encode($originalContent);
        $printJob->source = $options['source'] ?? config('app.name');
        $printJob->title =  $options['title'] ?? _p('printer::nodeprinter.no_title', 'No title');
        return $request->post($printJob);
    }
}
