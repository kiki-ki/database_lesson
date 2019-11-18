<HTML>
<HEAD>
  <TITLE>著者データ更新フォーム</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

著者データ 更新フォーム<BR><BR>

<FORM ACTION="author_update.php" METHOD="GET">

<!-- ここからPHPのスクリプト始まり -->
<?php

// 引数の著者番号を取得
$author_id = (integer) $_GET[ author_id ];

// データベースに接続
// ※ your_db_name のところは自分のデータベース名に書き換える
$conn = pg_connect( "dbname=aapi4255" );

// 接続が成功したかどうか確認
if ( $conn == null )
{
	print( "データベース接続処理でエラーが発生しました。<BR>" );
	exit;
}

// 指定された著者番号の著者情報を取得するSQLを作成
$sql = sprintf( "select name,homepage from author where author_id='%d'", $author_id );

// Queryを実行して検索結果をresultに記録
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 著者が見つからなければエラーメッセージを表示
if ( pg_num_rows( $result ) == 0 )
{
	print( "指定された著者番号のデータが見つかりません。<BR>\n" );
	exit;
}

// 検索結果の著者の情報を変数に記録
$curr_name = pg_fetch_result( $result, 0, 0 );
$curr_homepage = pg_fetch_result( $result, 0, 1 );

// 検索結果の行数を取得
$rows = pg_num_rows( $result );

// 検索結果の開放
pg_free_result( $result );

// 著者番号を更新スクリプトに渡す
printf( "<INPUT TYPE=hidden NAME=author_id VALUE=%d>\n", $author_id );

// データベースへの接続を解除
pg_close( $conn );

// 著者名の入力フィールドを出力
print( "<BR>\n" );
print( "著者名：\n" );
printf( "<INPUT TYPE=text SIZE=20 NAME=name VALUE=\"%s\">\n", $curr_name );
print( "　\n" );

// ホームページの入力フィールドを出力
print( "著者のホームページ：\n" );
printf( "<INPUT TYPE=url NAME=homepage VALUE=%s>\n", $curr_homepage );

?>
<!-- ここまででPHPのスクリプト終わり -->

<BR><BR>
<INPUT TYPE="submit" VALUE="送信"><BR>

</FORM>

</BODY>
</HTML>