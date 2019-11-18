<HTML>
<HEAD>
  <TITLE>保管場所データ更新フォーム</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

保管場所データ 更新フォーム<BR><BR>

<FORM ACTION="storage_update.php" METHOD="GET">

<!-- ここからPHPのスクリプト始まり -->
<?php

// 引数の保管場所番号を取得
$storage_id = (integer) $_GET[ storage_id ];

// データベースに接続
// ※ your_db_name のところは自分のデータベース名に書き換える
$conn = pg_connect( "dbname=aapi4255" );

// 接続が成功したかどうか確認
if ( $conn == null )
{
	print( "データベース接続処理でエラーが発生しました。<BR>" );
	exit;
}

// 指定された保管場所番号の保管場所情報を取得するSQLを作成
$sql = sprintf( "select location from storage where storage_id='%d'", $storage_id );

// Queryを実行して検索結果をresultに記録
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 保管場所が見つからなければエラーメッセージを表示
if ( pg_num_rows( $result ) == 0 )
{
	print( "指定された保管場所番号のデータが見つかりません。<BR>\n" );
	exit;
}

// 検索結果の保管場所の情報を変数に記録
$curr_location = pg_fetch_result( $result, 0, 0 );

// 検索結果の行数を取得
$rows = pg_num_rows( $result );

// 検索結果の開放
pg_free_result( $result );

// 保管場所番号を更新スクリプトに渡す
printf( "<INPUT TYPE=hidden NAME=storage_id VALUE=%d>\n", $storage_id );

// データベースへの接続を解除
pg_close( $conn );

// 保管場所の入力フィールドを出力
print( "<BR>\n" );
print( "保管場所：\n" );
printf( "<INPUT TYPE=text SIZE=50 NAME=location VALUE=\"%s\">\n", $curr_location );
print( "　\n" );

?>
<!-- ここまででPHPのスクリプト終わり -->

<BR><BR>
<INPUT TYPE="submit" VALUE="送信"><BR>

</FORM>

</BODY>
</HTML>