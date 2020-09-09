<?php

namespace App\Http\Requests\Diary;

use Illuminate\Foundation\Http\FormRequest;

class DiarySearchRequest extends FormRequest
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
            'since_date' => 'nullable|date',
            'until_date' => 'nullable|date|after_or_equal:since_date',
            'author_id' => 'integer|nullable',
        ];
    }

    public function messages()
    {
        return [
            'author_id.integer' => "投稿者IDは整数で入力してください",
            'until_date.after_or_equal:since_date' => "untilはsinceより後の日付を指定してください"
        ];
    }
}
