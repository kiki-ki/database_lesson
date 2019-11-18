<HTML>
<HEAD>
  <TITLE>蔵書データ更新フォーム</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

蔵書データ 更新フォーム<BR><BR>

<FORM ACTION="book_update.php" METHOD="GET">

<!-- ここからPHPのスクリプト始まり -->
<?php

// 引数の従業員番号を取得
$isbn = $_GET[ isbn ];

// データベースに接続
// ※ your_db_name のところは自分のデータベース名に書き換える
$conn = pg_connect( "dbname=aapi4255" );

// 接続が成功したかどうか確認
if ( $conn == null )
{
	print( "データベース接続処理でエラーが発生しました。<BR>" );
	exit;
}

// 指定されたisbnコードの本の情報を取得するSQLを作成
$sql = sprintf( "select title, date_of_issue, author_id, publisher_id, storage_id
                from book_info where isbn='%s'", $isbn );

// Queryを実行して検索結果をresultに記録
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 本が見つからなければエラーメッセージを表示
if ( pg_num_rows( $result ) == 0 )
{
	print( "指定された従業員番号のデータが見つかりません。<BR>\n" );
	exit;
}

// 検索結果の本の情報を変数に記録
$curr_title = pg_fetch_result( $result, 0, 0 );
$curr_date_of_issue = pg_fetch_result( $result, 0, 1 );
$curr_author_id = pg_fetch_result( $result, 0, 2 );
$curr_publisher_id = pg_fetch_result( $result, 0, 3 );
$curr_storage_id = pg_fetch_result( $result, 0, 4 );

// 検索結果の開放
pg_free_result( $result );

// isbnコードを更新スクリプトに渡す
printf( "<INPUT TYPE=hidden NAME=isbn VALUE=%s>\n", $isbn );

// 入力エリアを作成


print( "   本のタイトル：\n" );
printf( "<INPUT TYPE=text SIZE=50 NAME=title VALUE=%s>", $curr_title ); 


print( "   発行日：\n" );
printf( "<INPUT TYPE=date NAME=date_of_issue VALUE=%s>", $curr_date_of_issue ); 
print( "<BR>\n" );
print( "<BR>\n" );


// 著者一覧を取得するSQLの作成
$sql = "select author_id, name from author";

// Queryを実行して検索結果をresultに記録
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数を取得
$rows = pg_num_rows( $result );

// 著者の数だけ選択肢を出力
print( "著者名：\n" );
for ( $i=0; $i<$rows; $i++ )
{
	$author_id = pg_fetch_result( $result, $i, 0 );
	$name = pg_fetch_result( $result, $i, 1 );
	
	if ( $author_id == $curr_author_id )
		$checked = "CHECKED";
	else
		$checked = "";
	
	printf( "<INPUT TYPE=radio NAME=author_id VALUE=%d %s> %s </INPUT>\n", $author_id, $checked, $name );
}

// 検索結果の開放
pg_free_result( $result );

print( "<BR>\n" );
print( "<BR>\n" );
// 出版社一覧を取得するSQLの作成
$sql = "select publisher_id, name from publisher";

// Queryを実行して検索結果をresultに記録
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数を取得
$rows = pg_num_rows( $result );

// 出版社の数だけ選択肢を出力
print( "出版社名：\n" );
for ( $i=0; $i<$rows; $i++ )
{
	$publisher_id = pg_fetch_result( $result, $i, 0 );
	$name = pg_fetch_result( $result, $i, 1 );
	
	if ( $publisher_id == $curr_publisher_id )
		$checked = "CHECKED";
	else
		$checked = "";
	
	printf( "<INPUT TYPE=radio NAME=publisher_id VALUE=%d %s> %s </INPUT>\n", $publisher_id, $checked, $name );
}

// 検索結果の開放
pg_free_result( $result );

print( "<BR>\n" );
print( "<BR>\n" );
// 保管場所一覧を取得するSQLの作成
$sql = "select storage_id, location from storage";

// Queryを実行して検索結果をresultに記録
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数を取得
$rows = pg_num_rows( $result );

// 保管場所の数だけ選択肢を出力
print( "保管場所：\n" );
for ( $i=0; $i<$rows; $i++ )
{
	$storage_id = pg_fetch_result( $result, $i, 0 );
	$location = pg_fetch_result( $result, $i, 1 );
	
	if ( $storage_id == $curr_storage_id )
		$checked = "CHECKED";
	else
		$checked = "";
	
	printf( "<INPUT TYPE=radio NAME=storage_id VALUE=%d %s> %s </INPUT>\n", $storage_id, $checked, $location);
}

// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );


?>
<!-- ここまででPHPのスクリプト終わり -->

<BR><BR>
<INPUT TYPE="submit" VALUE="送信"><BR>

</FORM>

</BODY>
</HTML>