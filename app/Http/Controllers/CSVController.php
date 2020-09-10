<?php

namespace App\Http\Controllers;

use App\Diary;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SplFileObject;
use Exception;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CSVController extends Controller
{
    public function import_csv(Request $request)
    {
        // アップロードファイルのファイルパスを取得
        $file_path = $request->file('csv')->path();

        //SplFileObject化で1行ずつの処理を可能にする
        //SplFileObjectクラスはPHP固有の、ファイルのためのオブジェクト指向インターフェイスのためLaravelでインスタンス化を行う場合は先頭に「￥」をつける必要あり
        $file = new \SplFileObject($file_path);
        //CSVとして読み込み
        $file->setFlags(SplFileObject::READ_CSV);
        // 一行ずつ処理
        foreach ($file as $line) {
            //UTF8に変換
            mb_convert_variables('UTF-8', 'SJIS', $line);

            //ボタンのテーブルに応じて挿入処理

            if ($request->table == "diary") {
                if (count($line) == 2) {
                    Diary::create([
                        'text' => $line[0],
                        'author_id' => $line[1],
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime()
                    ]);
                }
            } elseif ($request->table == "user") {
                if (count($line) == 3) {
                    User::create([
                        "name" => $line[0],
                        "emails" => $line[1],
                        "password" => \Hash::make($line[2]),
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime()
                    ]);
                }
            }
        }
        return redirect()->back();
    }

    public function export_csv(Request $request)
    {
        //チェックされたユーザのuser_idを取得
        $user_id = $request->user_id;

        //現時刻取得
        $now = Carbon::now();
        //streamedresponse
        //第一引数にCSVの出力内容(コールバック)、第二引数にレスポンス、第三引数にレスポンスヘッダ
        $response = new StreamedResponse(
            function () use ($request) {

            // ファイルの書き出しはfopen()
            $stream = fopen('php://output', 'w');

            // ボタンのテーブルに応じてヘッダの設定
            if ($request->table == "diary") {
                $head = [
                '投稿ID',
                'テキスト',
                '投稿者ID',
                '登録日',
                '更新日'
            ];
            } elseif ($request->input("table") == "user") {
                $head = [
                    "ユーザID",
                    "名前",
                    "メールアドレス",
                    "パスワード",
                    "登録日",
                    "更新日"
                ];
            }
            // 宣言したストリームに対してヘッダを書き出し
            mb_convert_variables('SJIS-win', 'UTF-8', $head);
            fputcsv($stream, $head);

            if ($request->table == "diary") {
                $data = Diary::latest()->get();
                foreach ($data as $line) {
                    // ストリームに対して1行ごと書き出し
                    mb_convert_variables('SJIS-win', 'UTF-8', $line);
                    fputcsv($stream, [
                        $line['id'],
                        $line['text'],
                        $line['author_id'],
                        $line['created_at'],
                        $line['updated_at'],
                    ]);
                }
            } elseif ($request->table == "user") {
                $data = User::where("id",$user_id)->get();
                foreach ($data as $line) {
                    // ストリームに対して1行ごと書き出し
                    mb_convert_variables('SJIS-win', 'UTF-8', $line);
                    fputcsv($stream, [
                        $line['id'],
                        $line['name'],
                        $line['emails'],
                        $line["password"],
                        $line['created_at'],
                        $line['updated_at'],
                    ]);
                }
            }
            fclose($stream);
        },
            // StreamedResponseの第2引数（レスポンス）
            \Illuminate\Http\Response::HTTP_OK,
            // StreamedResponseの第3引数（レスポンスヘッダ）
            [
                'Content-Type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename='.$now->format('YmdHis').'.csv',
            ]
        );
        return $response;
    }
}
