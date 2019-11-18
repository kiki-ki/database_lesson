<HTML>
<HEAD>
  <TITLE>蔵書の検索結果</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

<CENTER>

検索結果を表示します。<BR><BR>

<!-- ここからPHPのスクリプト始まり -->
<?php

// 検索フォームから渡された引数を取得
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

if($author_id == "ALL" && $publisher_id == "ALL" && $storage_id == "ALL"){
	$sql ="select isbn, title, date_of_issue, author.name, publisher.name, location
			from book_info, author, publisher, storage 
			where book_info.author_id = author.author_id and 
			book_info.publisher_id = publisher.publisher_id and
			book_info.storage_id = storage.storage_id 
			order by author.author_id";
}
else if($author_id != "ALL" && $publisher_id == "ALL" && $storage_id == "ALL"){
	$sql ="select isbn, title, date_of_issue, author.name, publisher.name, location
			from book_info, author, publisher, storage 
			where book_info.author_id = author.author_id and 
			book_info.publisher_id = publisher.publisher_id and
			book_info.storage_id = storage.storage_id and 
			author.author_id='$author_id'
			order by date_of_issue";
}
else if($author_id == "ALL" && $publisher_id != "ALL" && $storage_id == "ALL"){
	$sql ="select isbn, title, date_of_issue, author.name, publisher.name, location
			from book_info, author, publisher, storage 
			where book_info.author_id = author.author_id and 
			book_info.publisher_id = publisher.publisher_id and
			book_info.storage_id = storage.storage_id and 
			publisher.publisher_id='$publisher_id'
			order by date_of_issue";
}
else if($author_id == "ALL" && $publisher_id == "ALL" && $storage_id != "ALL"){
	$sql ="select isbn, title, date_of_issue, author.name, publisher.name, location
			from book_info, author, publisher, storage 
			where book_info.author_id = author.author_id and 
			book_info.publisher_id = publisher.publisher_id and
			book_info.storage_id = storage.storage_id and 
			storage.storage_id='$storage_id'
			order by date_of_issue";
}
else if($author_id != "ALL" && $publisher_id != "ALL" && $storage_id == "ALL"){
	$sql ="select isbn, title, date_of_issue, author.name, publisher.name, location
			from book_info, author, publisher, storage 
			where book_info.author_id = author.author_id and 
			book_info.publisher_id = publisher.publisher_id and
			book_info.storage_id = storage.storage_id and 
			author.author_id='$author_id' and
			publisher.publisher_id='$publisher_id'
			order by date_of_issue";
}
else if($author_id != "ALL" && $publisher_id == "ALL" && $storage_id != "ALL"){
	$sql ="select isbn, title, date_of_issue, author.name, publisher.name, location
			from book_info, author, publisher, storage 
			where book_info.author_id = author.author_id and 
			book_info.publisher_id = publisher.publisher_id and
			book_info.storage_id = storage.storage_id and 
			author.author_id='$author_id' and
			storage.storage_id='$storage_id'
			order by date_of_issue";
}
else if($author_id == "ALL" && $publisher_id != "ALL" && $storage_id != "ALL"){
	$sql ="select isbn, title, date_of_issue, author.name, publisher.name, location
			from book_info, author, publisher, storage 
			where book_info.author_id = author.author_id and 
			book_info.publisher_id = publisher.publisher_id and
			book_info.storage_id = storage.storage_id and 
			publisher.publisher_id='$publisher_id' and
			storage.storage_id='$storage_id'
			order by date_of_issue";
}
else if($author_id != "ALL" && $publisher_id != "ALL" && $storage_id != "ALL"){
	$sql ="select isbn, title, date_of_issue, author.name, publisher.name, location
			from book_info, author, publisher, storage 
			where book_info.author_id = author.author_id and 
			book_info.publisher_id = publisher.publisher_id and
			book_info.storage_id = storage.storage_id and
			author.author_id='$author_id' and 
			publisher.publisher_id='$publisher_id' and
			storage.storage_id='$storage_id'
			order by date_of_issue";
}


// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数・列数を取得
$rows = pg_num_rows( $result );
$cols = pg_num_fields( $result );


// 検索結果をテーブルとして表示
print( "<TABLE BORDER=1>\n" );

// 各列の名前を表示
print( "<TR>" );
print( "<TH>ISBNコード</TH>" );
print( "<TH>本のタイトル</TH>" );
print( "<TH>発行日</TH>" );
print( "<TH>著者名</TH>" );
print( "<TH>出版社名</TH>" );
print( "<TH>保管場所</TH>" );
print( "</TR>\n" );

// 各行のデータを表示
for ( $j=0; $j<$rows; $j++ )
{
	print( "<TR>" );
	for ( $i=0; $i<$cols; $i++ )
	{
		// j行i列のデータを取得
		$data = pg_fetch_result( $result, $j, $i );
		
		// セルに列の名前を表示
		print( "<TD> $data </TD>" );
	}
	print( "</TR>\n" );
}

// ここまででテーブル終了
print( "</TABLE>" );
print( "<BR>\n" );


// 検索件数を表示
print( "以上、$rows 件のデータを表示しました。<BR>\n" );


// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );

?>
<!-- ここまででPHPのスクリプト終わり -->

<BR>
<A HREF="Book_menu.html">操作メニューに戻る</A>

</CENTER>

</BODY>
</HTML>