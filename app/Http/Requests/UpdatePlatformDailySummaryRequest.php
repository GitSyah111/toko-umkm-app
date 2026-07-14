<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlatformDailySummaryRequest extends FormRequest
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
            'tanggal' => ['required', 'date', 'unique:platform_daily_summaries,tanggal,' . $this->route('platform_summary')->id],
            'total_gmv' => ['required', 'numeric', 'min:0'],
            'total_orders' => ['required', 'integer', 'min:0'],
            'total_active_tokos' => ['required', 'integer', 'min:0'],
        ];
    }
}
