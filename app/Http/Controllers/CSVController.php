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
    /**
     * CSVインポート
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function importCsv(Request $request)
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
                $col = 2;

                if (count($line) == $col) {
                    //※created,updatedはcreateメソッドで自動生成されるため不要
                    Diary::create([
                        'text' => $line[0],
                        'author_id' => $line[1],
                    ]);
                }
            } elseif ($request->table == "user") {
                $col = 3;
                if (count($line) == $col) {
                    //※created,updatedはcreateメソッドで自動生成されるため不要
                    User::create([
                        "name" => $line[0],
                        "email" => $line[1],
                        "password" => \Hash::make($line[2]),
                    ]);
                }
            }
        }
        return redirect()->back();
    }

    /**
     * CSVエクスポート
     *
     * @param Request $request
     * @return StreamedResponse
     */
    public function exportCsv(Request $request)
    {
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

                    //検索結果のidを条件にエクスポート
                    $diary_ids = $request->session()->get("diary_search_session");//セッション取り出し
                    $data = Diary::whereIn("id", $diary_ids)->get();
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

                    //検索結果のidを条件にエクスポート
                    $user_ids = $request->session()->get("user_search_session");//セッション取り出し
                    $data = User::where("id", $user_ids)->get();
                    foreach ($data as $line) {
                        // ストリームに対して1行ごと書き出し
                        mb_convert_variables('SJIS-win', 'UTF-8', $line);
                        fputcsv($stream, [
                            $line['id'],
                            $line['name'],
                            $line['email'],
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
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename=' . $now->format('YmdHis') . '.csv',
            ]
        );
        return $response;
    }
}
