<?php

namespace App\Http\Requests;

use App\Enums\PopupRetrievalStrategy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetPopupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(array_column(PopupRetrievalStrategy::cases(), 'value'))],
            'owner_id' => ['required_if:type,owner', 'exists:users,id'],
            'page_url' => ['required_if:type,page', 'url'],
            'type_id'  => ['sometimes', 'required_if:type,filter', 'exists:popup_types,id'],
            'layout_type_id' => ['sometimes', 'required_if:type,filter', 'exists:popup_layout_types,id']
        ];
    }
}
