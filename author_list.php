<HTML>
<HEAD>
  <TITLE>登録著者一覧</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

<CENTER>

登録著者一覧<BR><BR>

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

// SQLを作成
$sql = "select *
        from author
        order by author_id";

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
print( "<TH>著者番号</TH>" );
print( "<TH>著者名</TH>" );
print( "<TH>著者のホームページ</TH>" );
print( "</TR>\n" );

// 各行のデータを表示
for ( $j=0; $j<$rows; $j++ )
{
	print( "<TR>" );
	for ( $i=0; $i<$cols; $i++ )
	{
		// j行i列のデータを取得
        $data = pg_fetch_result( $result, $j, $i );
        //ホームページの列をリンク化
        if($i==2)
            print( "<TD> <a href=$data>$data</a> </TD>" );
        else
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
<HR> 
<BR>
<A HREF="author_add_form.php">データの追加</A>
<BR>
<A HREF="author_update_form1.php">データの更新</A>
<BR>
<A HREF="author_delete_form.php">データの削除</A>
<BR>
<BR>
<A HREF="Book_menu.html">操作メニューに戻る</A>

</CENTER>

</BODY>
</HTML>