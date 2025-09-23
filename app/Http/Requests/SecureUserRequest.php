<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SecureUserRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\-\'\.]+$/', // Only letters, spaces, hyphens, apostrophes, periods
            ],
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:255',
                'unique:users,email,' . ($this->user?->id ?? 'NULL'),
            ],
            'role' => [
                'required',
                'string',
                'in:admin,leader,user', // Whitelist allowed roles
            ],
            'g12_leader_id' => [
                'nullable',
                'integer',
                'exists:g12_leaders,id',
            ],
        ];

        // Add password validation for create/update operations
        if ($this->isMethod('POST') || $this->has('password')) {
            $rules['password'] = [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed',
            ];
        }

        return $rules;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Sanitize inputs before validation
        $this->merge([
            'name' => $this->sanitizeString($this->name),
            'email' => $this->sanitizeEmail($this->email),
            'role' => $this->sanitizeString($this->role),
        ]);
    }

    /**
     * Sanitize string input
     */
    private function sanitizeString(?string $input): ?string
    {
        if ($input === null) {
            return null;
        }

        // Remove potentially dangerous characters
        $input = preg_replace('/[<>\"\'%;()&+]/', '', $input);
        
        // Remove excessive whitespace
        $input = preg_replace('/\s+/', ' ', trim($input));
        
        return $input;
    }

    /**
     * Sanitize email input
     */
    private function sanitizeEmail(?string $email): ?string
    {
        if ($email === null) {
            return null;
        }

        // Remove any characters that shouldn't be in an email
        $email = preg_replace('/[^a-zA-Z0-9@._-]/', '', $email);
        
        return strtolower(trim($email));
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.regex' => 'The name may only contain letters, spaces, hyphens, apostrophes, and periods.',
            'email.email' => 'Please provide a valid email address.',
            'password.uncompromised' => 'The given password has appeared in a data leak. Please choose a different password.',
            'role.in' => 'Invalid role selected.',
        ];
    }
}