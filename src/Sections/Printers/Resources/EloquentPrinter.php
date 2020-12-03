<?php

namespace AwemaPL\Printer\Sections\Printers\Resources;

use AwemaPL\Printer\Sections\Printers\Models\Contracts\Printable;
use Illuminate\Http\Resources\Json\JsonResource;

class EloquentPrinter extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'printable' => $this->printable,
            'provider' =>  $this->printable->getProviderName(),
            'printer_name' => $this->printable->name,
            'created_at' =>$this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
