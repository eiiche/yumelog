<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "user_image" => ['required','file','image','mimes:jpeg,png','dimensions:ratio=1/1'],
        ];
    }

    //エラーメッセージのカスタム
    public function messages()
    {
        return [
            'user_image.required'  => '画像を指定してください',
            'user_image.mimes:jpeg,png' => '画像はjpegかpngを指定してください',
            'user_image.dimensions:ratio=1/1' => '画像は1:1の比率でアップロードしてください'
        ];
    }
}
