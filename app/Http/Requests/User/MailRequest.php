<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class MailRequest extends FormRequest
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
            'title' => 'required',
            'text' => 'required',
            'user_id' => 'required',
        ];
    }

    //エラーメッセージのカスタム
    public function messages()
    {
        return [
            'title.required'  => '件名を入力してください',
            'text.required' => '本文を入力してください',
            'user_id.required' => '送信先をチェックしてください'
        ];
    }
}
