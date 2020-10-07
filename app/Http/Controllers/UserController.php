<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\MailRequest;
use App\Mail\notification;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    /**
     * フォームから受け取ったactionの内容で削除orメール配信orCSVエクスポートに振り分け
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function check(Request $request)
    {
        //name="action"のタグのvalueの値で振り分け
        if ($request->input('action') == "delete") {
            redirect(route("user_multiple_delete"))->with($request);//一括削除
        } elseif ($request->input('action') == "mail") {
            $this->mail($request);//メール一括配信
        } elseif ($request->input('action') == "csv_export") {
            return redirect(route("export_csv"))->with($request);//csvエクスポート
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        $checked_user_id = $request->user_id;
        User::destroy($checked_user_id);

        return redirect()->back();
    }

    /**
     * メール配信
     *
     * @param Request $request
     */
    public function mail(MailRequest $request)
    {
        $destination = User::whereIn("id", $request->user_id)->get()->pluck('email');
        $title = $request->title;
        $text = $request->text;

        Mail::bcc($destination)->send(new notification($title, $text));
        return redirect()->back();
    }
}
