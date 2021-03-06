<?php
namespace App\Http\Requests\Diary;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()//ユーザの認証チェック
    {
        return true; //[ *1.変更：default=false ]
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //[ *2.追加：Validationルール記述箇所 ]
        return [
            'text'   => [ 'required', 'string', 'max:300'], // 詳細は仕様を検討ください
        ];
    }

    //[ *3.追加：属性名を設定（省略可） ]
    //function名は必ず「attributes」となります。
    public function attributes()
    {
        return [
            'text'  => 'ゆめログ',
        ];
    }

    //エラーメッセージのカスタム
    public function messages()
    {
        return [
            'text.required'  => '内容を入力してください',
            'text.min:300' => '300文字以下で入力してください'
        ];
    }

    // [ *4.追加：validated関数でフォームの値を連想配列で取得。連想配列にauthorIdを追加する（省略可） ]
    // Requestクラス(親クラス)、user()メソッドにてauthorIdにリクエストを作成したユーザーを代入し、validatedで返却することでControllerの処理を簡易化する
    public function validated()
    {
        return parent::validated() + [ 'author_id' => $this->user()->id ];
    }
}
