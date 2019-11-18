<HTML>
<HEAD>
  <TITLE>蔵書データ追加フォーム</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

蔵書データ 追加フォーム<BR><BR>

<FORM ACTION="book_add.php" METHOD="GET">

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

// 入力エリアを作成
print( "ISBNコード：\n" );
printf( "<INPUT TYPE=text SIZE=13 NAME=isbn>" ); 


print( "   本のタイトル：\n" );
printf( "<INPUT TYPE=text SIZE=50 NAME=title>" ); 


print( "   発行日：\n" );
printf( "<INPUT TYPE=date NAME=date_of_issue>" ); 
print( "<BR>\n" );
print( "<BR>\n" );

// 検索結果の開放
pg_free_result( $result );


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

// 検索結果の開放
pg_free_result( $result );


// データベースへの接続を解除
pg_close( $conn );

?>
<!-- ここまででPHPのスクリプト終わり -->
<BR><BR>
<INPUT TYPE="submit" VALUE="送信"><BR>

<BR>
<A HREF="Book_list">蔵書一覧に戻る</A>

</FORM>

</BODY>
</HTML>