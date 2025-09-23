<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SecureMemberRequest extends FormRequest
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
        return [
            'first_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\-\'\.]+$/', // Only letters, spaces, hyphens, apostrophes, periods
            ],
            'middle_name' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\-\'\.]+$/',
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\-\'\.]+$/',
            ],
            'email' => [
                'nullable',
                'string',
                'email:rfc,dns',
                'max:255',
                'unique:members,email,' . ($this->member?->id ?? 'NULL'),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[\+]?[0-9\s\-\(\)]+$/', // Phone number format
            ],
            'address' => [
                'nullable',
                'string',
                'max:500',
            ],
            'date_of_birth' => [
                'nullable',
                'date',
                'before:today',
            ],
            'member_type_id' => [
                'required',
                'integer',
                'exists:member_types,id',
            ],
            'status_id' => [
                'required',
                'integer',
                'exists:statuses,id',
            ],
            'g12_leader_id' => [
                'nullable',
                'integer',
                'exists:g12_leaders,id',
            ],
            'consolidator_id' => [
                'nullable',
                'integer',
                'exists:members,id',
            ],
            'vip_status_id' => [
                'nullable',
                'integer',
                'exists:vip_statuses,id',
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Sanitize inputs before validation
        $this->merge([
            'first_name' => $this->sanitizeString($this->first_name),
            'middle_name' => $this->sanitizeString($this->middle_name),
            'last_name' => $this->sanitizeString($this->last_name),
            'email' => $this->sanitizeEmail($this->email),
            'phone' => $this->sanitizePhone($this->phone),
            'address' => $this->sanitizeAddress($this->address),
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
     * Sanitize phone input
     */
    private function sanitizePhone(?string $phone): ?string
    {
        if ($phone === null) {
            return null;
        }

        // Remove all characters except numbers, spaces, hyphens, parentheses, and plus
        $phone = preg_replace('/[^0-9\s\-\(\)\+]/', '', $phone);
        
        return trim($phone);
    }

    /**
     * Sanitize address input
     */
    private function sanitizeAddress(?string $address): ?string
    {
        if ($address === null) {
            return null;
        }

        // Remove potentially dangerous characters but allow common address characters
        $address = preg_replace('/[<>\"\'%;()&]/', '', $address);
        
        // Remove excessive whitespace
        $address = preg_replace('/\s+/', ' ', trim($address));
        
        return $address;
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'first_name.regex' => 'The first name may only contain letters, spaces, hyphens, apostrophes, and periods.',
            'middle_name.regex' => 'The middle name may only contain letters, spaces, hyphens, apostrophes, and periods.',
            'last_name.regex' => 'The last name may only contain letters, spaces, hyphens, apostrophes, and periods.',
            'email.email' => 'Please provide a valid email address.',
            'phone.regex' => 'Please provide a valid phone number format.',
            'date_of_birth.before' => 'Date of birth must be in the past.',
        ];
    }
}