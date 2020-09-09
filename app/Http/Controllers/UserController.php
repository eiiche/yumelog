<?php

namespace App\Http\Controllers;

use App\Mail\notification;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //
    }

    //フォームsubmitのvalueの値で処理を振り分け
    public function check(Request $request)
    {
        //name="action"のタグのvalueの値で振り分け
        if ($request->input('action') == "delete") {
            $this->destroy($request);//一括削除
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
        User::destroy($request->user_id);

        return redirect()->back();
    }

    public function mail(Request $request)
    {
        $destination = User::where("id", $request->user_id)->get();
        $title = $request->title;
        $text = $request->text;

        Mail::bcc($destination)->send(new notification($title, $text));
    }
}
