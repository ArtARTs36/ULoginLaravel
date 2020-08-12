<?php

namespace ArtARTs36\ULoginLaravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AuthRequest
 * @package ArtARTs36\ULoginLaravel\Http\Requests
 */
class AuthRequest extends FormRequest
{
    public const FIELD_TOKEN = 'token';

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            static::FIELD_TOKEN => 'required|string',
        ];
    }
}
