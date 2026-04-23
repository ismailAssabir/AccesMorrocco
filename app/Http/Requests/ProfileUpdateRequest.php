<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstName' => ['required', 'string', 'max:50'],
            'lastName' => ['required', 'string', 'max:50'],
            'cin' => ['required', 'string', 'max:50', Rule::unique(User::class)->ignore($this->user()->idUser, 'idUser')],
            'birthday' => ['required', 'date'],
            'address' => ['nullable', 'string', 'max:100'],
            'phoneNumber' => ['required', 'string', 'max:15'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:50',
                Rule::unique(User::class)->ignore($this->user()->idUser, 'idUser'),
            ],
        ];

    }
}
