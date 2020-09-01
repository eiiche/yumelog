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
        foreach($file as $line)
        {
            //UTF8に変換
            mb_convert_variables('UTF-8', 'SJIS', $line);
            //挿入処理
            Diary::insert(array(
                'text' => $line[0],
                'author_id' => $line[1],
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ));
        }
        return redirect()->back();
    }

    public function export_csv()
    {
        dd("a");
        //現時刻取得
        $now = Carbon::now();
        //streamedresponse
        //第一引数にCSVの出力内容(コールバック)、第二引数にレスポンス、第三引数にレスポンスヘッダ
        $response = new StreamedResponse(function () {

            // ファイルの書き出しはfopen()
            $stream = fopen('php://output', 'w');
            // ヘッダの設定
            $head = [
                '投稿ID',
                'テキスト',
                '投稿者ID',
                '登録日',
                '更新日'
            ];
            // 宣言したストリームに対してヘッダを書き出し
            mb_convert_variables('SJIS-win', 'UTF-8', $head);
            fputcsv($stream, $head);

            $data = Diary::latest()->get();
                foreach ($data as $line)
                {
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
         return redirect()->back()->with($response);
    }
}
