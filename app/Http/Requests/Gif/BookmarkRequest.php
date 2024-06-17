<?php

namespace App\Http\Requests\Gif;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\RegisterUser;

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
            'USER_ID'   => ['required', 'numeric', new RegisterUser],
            'GIF_ID'    => 'required',
            'ALIAS'     => 'required',
        ];
    }
}
