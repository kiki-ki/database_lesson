<HTML>
<HEAD>
  <TITLE>蔵書データ更新処理スクリプト</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

<!-- ここからPHPのスクリプト始まり -->
<?php

// フォームから渡された引数を取得
$isbn = $_GET[ isbn ];
$title = $_GET[ title ];
$date_of_issue = $_GET[ date_of_issue ];
$author_id = $_GET[ author_id ];
$publisher_id = $_GET[ publisher_id ];
$storage_id = $_GET[ storage_id ];

// データベースに接続
// ※ your_db_name のところは自分のデータベース名に書き換える
$conn = pg_connect( "dbname=aapi4255" );

// 接続が成功したかどうか確認
if ( $conn == null )
{
	print( "データベース接続処理でエラーが発生しました。<BR>" );
	exit;
}

// データ更新のSQLを作成
$sql = "update book_info set isbn='$isbn',title='$title',date_of_issue='$date_of_issue',
        author_id='$author_id',publisher_id='$publisher_id',storage_id='$storage_id' where isbn='$isbn'";

// 確認用のメッセージ表示
print( "クエリー「" );
print( $sql );
print( "」を実行します。<BR>" );

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );

?>
<!-- ここまででPHPのスクリプト終わり -->

データの更新処理が完了しました。<BR>
<BR>
<A HREF="Book_list.php">蔵書一覧に戻る</A>

</BODY>
</HTML>