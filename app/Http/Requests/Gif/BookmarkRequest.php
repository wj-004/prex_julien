<?php

namespace App\Http\Requests\Gif;

use Illuminate\Foundation\Http\FormRequest;


class BookmarkRequest extends FormRequest
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
            'USER_ID'   => 'required|exists:users,id',
            'GIF_ID'    => 'required',
            'ALIAS'     => 'required',
        ];
    }
}
