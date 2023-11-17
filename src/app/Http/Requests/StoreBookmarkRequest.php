<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookmarkRequest extends FormRequest
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
        // https://stackoverflow.com/questions/417142/what-is-the-maximum-length-of-a-url-in-different-browsers
        $maxUrlLength = env('APP_MAX_URL_LENGTH', 2048);

        return [
            'name' => [ 'required', 'min:1', 'max:255'],
            'url' => ['required', 'url:http,https', 'max:' . $maxUrlLength],
            'category' => ['required', 'min:1', 'max:255'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages()
    {
        $maxUrlLength = env('APP_MAX_URL_LENGTH', 2048);

        return [
            'required' => 'The :attribute is required.',
            'name.max' => 'The name cannot exceed 255 characters.',
            'category.max' => 'The category cannot exceed 255 characters.',
            'url.url' =>  'The url must be valid.',
            'url.max' =>  "The url cannot exceed $maxUrlLength characters."
        ];
    }
}
