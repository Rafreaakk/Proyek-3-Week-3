<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
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
            'category_id' => ['required', 'exists:categories,id'],

            'code' => [
                'required',
                'string',
                'max:30',
                Rule::unique('activities', 'code')->ignore($this->route('activity'))
            ],
            // BR-01: Judul wajib diisi, minimal 5 karakter, maksimal 100 karakter
            'title' => ['required', 'string', 'min:5', 'max:100'],
            
            // BR-02: Tanggal wajib diisi dan formatnya harus tanggal valid
            'activity_date' => ['required', 'date'],
            
            // BR-03: Status wajib diisi dan hanya boleh salah satu dari 3 nilai ini
            'status' => ['required', 'in:Planned,Ongoing,Done'],
        ];
    }
}
