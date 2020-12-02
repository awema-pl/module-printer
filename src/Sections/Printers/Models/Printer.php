<?php

namespace AwemaPL\Printer\Sections\Printers\Models;

use Illuminate\Database\Eloquent\Model;
use AwemaPL\Printer\Sections\Printers\Models\Contracts\Printer as PrinterContract;

class Printer extends Model implements PrinterContract
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id'];
    
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
        return config('printer.database.tables.printer_printers');
    }

    /**
     * Get the owning printable model.
     */
    public function printable()
    {
        return $this->morphTo();
    }
 
}
