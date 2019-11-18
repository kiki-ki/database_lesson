<HTML>
<HEAD>
  <TITLE>蔵書の検索フォーム</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

<CENTER>

蔵書データ 検索フォーム<BR><BR>

検索したい本の条件を選択して送信ボタンを押してください。<BR><BR>

<FORM ACTION="search_book.php" METHOD="GET">

<!-- ここからPHPのスクリプト始まり -->
<?php

// データベースに接続
// ※ your_db_name のところは自分のデータベース名に書き換える
$conn = pg_connect( "dbname=aapi4255" );

// 接続が成功したかどうか確認
if ( $conn == null )
{
	print( "データベース接続処理でエラーが発生しました。<BR>" );
	exit;
}

// 著者一覧を取得するSQLの作成
$sql = "select author_id, name from author";

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数を取得
$rows = pg_num_rows( $result );

// 著者の数だけ選択肢を出力
print( "著者：\n" );
for ( $i=0; $i<$rows; $i++ )
{
	$author_id = pg_fetch_result( $result, $i, 0 );
	$name = pg_fetch_result( $result, $i, 1 );
	printf( "<INPUT TYPE=\"radio\" NAME=\"author_id\" VALUE=\"%d\"> %s </INPUT>\n", $author_id, $name );
}
printf( "<INPUT TYPE=\"radio\" NAME=\"author_id\" VALUE=\"ALL\"CHECKED> </INPUT>指定しない\n" );

// 検索結果の開放
pg_free_result( $result );

echo "<br />";
// 出版社一覧を取得するSQLの作成
$sql = "select publisher_id, name from publisher";

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数を取得
$rows = pg_num_rows( $result );

// 出版社の数だけ選択肢を出力
echo "<br />";
print( "出版社：\n" );
for ( $i=0; $i<$rows; $i++ )
{
	$publisher_id = pg_fetch_result( $result, $i, 0 );
	$name = pg_fetch_result( $result, $i, 1 );
	printf( "<INPUT TYPE=\"radio\" NAME=\"publisher_id\" VALUE=\"%d\"> %s </INPUT>\n", $publisher_id, $name );
}
printf( "<INPUT TYPE=\"radio\" NAME=\"publisher_id\" VALUE=\"ALL\"CHECKED> </INPUT>指定しない\n" );

// 検索結果の開放
pg_free_result( $result );

echo "<br />";
// 保管場所一覧を取得するSQLの作成
$sql = "select storage_id, location from storage";

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数を取得
$rows = pg_num_rows( $result );

// 保管場所の数だけ選択肢を出力
echo "<br />";
print( "保管場所：\n" );
for ( $i=0; $i<$rows; $i++ )
{
	$storage_id = pg_fetch_result( $result, $i, 0 );
	$location = pg_fetch_result( $result, $i, 1 );
	printf( "<INPUT TYPE=\"radio\" NAME=\"storage_id\" VALUE=\"%d\"> %s </INPUT>\n", $storage_id, $location);
}
printf( "<INPUT TYPE=\"radio\" NAME=\"storage_id\" VALUE=\"ALL\"CHECKED> </INPUT>指定しない\n" );

echo "<br />";

// 検索結果の開放
pg_free_result( $result );


// データベースへの接続を解除
pg_close( $conn );

?>
<!-- ここまででPHPのスクリプト終わり -->

<BR>
<INPUT TYPE="submit" VALUE="送信"><BR>

</FORM>

<BR>
<A HREF="Book_menu.html">操作メニューに戻る</A>

</CENTER>

</BODY>
</HTML>