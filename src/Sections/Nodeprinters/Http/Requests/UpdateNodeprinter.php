<?php

namespace AwemaPL\Printer\Sections\Nodeprinters\Http\Requests;

use AwemaPL\Printer\Sections\Options\Models\Option;
use AwemaPL\Printer\Sections\Nodeprinters\Http\Requests\Rules\ApiTokenValid;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNodeprinter extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'api_key' => 'required|string|max:255',
            'printer_id' => ['required', 'integer',  Rule::unique(config('printer.database.tables.printer_nodeprinters'))->where(function ($query) {
                return $query->where('printer_id', $this->printer_id)
                    ->where('user_id', $this->user()->id);
            })->ignore($this->id)],
        ];
    }


    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => _p('printer::requests.nodeprinter.attributes.name', 'name'),
            'api_key' => _p('printer::requests.nodeprinter.attributes.api_key', 'API key'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'printer_id.required' => _p('printer::requests.nodeprinter.messages.please_select_printer', 'Please select a printer.'),
            'printer_id.unique' => _p('printer::requests.nodeprinter.messages.this_printer_is_added', 'This printer has already been added.'),
        ];
    }
}
