<?php

namespace App\Http\Requests;

use App\Enums\PopupLayoutType;
use App\Enums\PopupType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePopupRequest extends FormRequest
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
            'type_id' => ['required', 'exists:popup_types,id'],
            'layout_type_id' => ['required', 'exists:popup_layout_types,id'],
            'content' => ['required', 'json']
        ];
    }
}
