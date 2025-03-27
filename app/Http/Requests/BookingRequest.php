<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\AbonnementNumberRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookingRequest extends FormRequest
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
            'booking_date' => ['required', 'date', 'after:today'],
            'time_slot' => ['required', Rule::in([
                '10:00-12:00',
                '12:00-14:00',
                '14:00-16:00',
                '16:00-18:00',
                '18:00-20:00',
            ])],
            'visitors' => ['required', 'array', 'min:1', 'max:3'],
            'visitors.*.first_name' => ['required', 'string', 'max:255'],
            'visitors.*.last_name' => ['required', 'string', 'max:255'],
            'visitors.*.abonnement_number' => ['nullable', new AbonnementNumberRule],
        ];
    }
}
