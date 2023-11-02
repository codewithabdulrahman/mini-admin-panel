<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'logo' => [
                'sometimes',
                function ($attribute, $value, $fail) {
                    // Check if the input is a file
                    if (is_uploaded_file($value) || is_a($value, 'Illuminate\Http\UploadedFile')) {
                        $image = getimagesize($value);

                        if ($image === false) {
                            $fail("The $attribute is not a valid image file.");
                        }

                        list($width, $height) = $image;

                        if ($width < 100 || $height < 100) {
                            $fail("The $attribute dimensions must be at least 100x100 pixels.");
                        }
                    }
                },
            ],
            'website' => 'nullable|url',
        ];
    }
}
