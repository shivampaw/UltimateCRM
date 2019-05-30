<?php

namespace App\Http\Requests;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRecurringInvoiceRequest extends FormRequest
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
            'discount' => 'nullable|numeric',
            'item_details' => 'required|array',
            'item_details.*.description' => 'required',
            'item_details.*.price' => 'required',
            'item_details.*.quantity' => 'required',
            'how_often' => 'required',
            'due_date' => 'required|numeric',
            'notes' => 'nullable',
            'next_run' => 'nullable|date|after_or_equal:today',
            'project_id' => [
                'nullable',
                Rule::exists('projects', 'id')->where(function (Builder $query) {
                    $query->where('client_id', $this->route('client'));
                }),
            ],
        ];
    }

    /**
     * Get the validation rule messages that apply to
     * the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'project_id.exists' => 'The Project ID you entered does not exist for this user.',
            'item_details.*.price.required' => 'Every item must have a price.',
            'item_details.*.description.required' => 'Every item must have a description.',
            'item_details.*.quantity.required' => 'Every item must have a quantity.',
            'next_run.after_or_equal' => 'The first run date must be today or in the future.'
        ];
    }
}
