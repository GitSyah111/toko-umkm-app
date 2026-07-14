<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTokoDailySummaryRequest extends FormRequest
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
            'tanggal' => [
                'required', 
                'date', 
                \Illuminate\Validation\Rule::unique('toko_daily_summaries')->where(function ($query) {
                    return $query->where('toko_id', \Illuminate\Support\Facades\Auth::user()->toko->id);
                })->ignore($this->route('toko_summary')->id)
            ],
            'total_revenue' => ['required', 'numeric', 'min:0'],
            'total_orders' => ['required', 'integer', 'min:0'],
        ];
    }
}
