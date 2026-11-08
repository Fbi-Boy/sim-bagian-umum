<?php

namespace App\Http\Requests\Modules\Organization;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationalUnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('organization.units.create') ?? false;
    }

    public function rules(): array
    {
        return [
            'parent_id' => ['nullable', 'exists:organizational_units,id'],
            'code' => ['required', 'string', 'max:40', 'unique:organizational_units,code'],
            'name' => ['required', 'string', 'max:160'],
            'unit_type' => ['required', 'string', 'max:40'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'effective_from' => ['nullable', 'date'],
            'effective_until' => ['nullable', 'date', 'after_or_equal:effective_from'],
        ];
    }
}