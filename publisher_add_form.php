<HTML>
<HEAD>
  <TITLE>出版社データ追加フォーム</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

出版社データ 追加フォーム<BR><BR>

<FORM ACTION="publisher_add.php" METHOD="GET">

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


// 最も大きな出版社番号を取り出すSQLの作成
$sql = "select max(publisher_id) from publisher";

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 最大の出版社番号を取得
if ( pg_num_rows( $result ) > 0 )
	$max_id = pg_fetch_result( $result, 0, 0 );
$max_id ++;

// 出版社番号の初期値を指定して入力エリアを作成
print( "出版社番号：\n" );
printf( "<INPUT TYPE=text NAME=publisher_id VALUE=%3d>", $max_id ); 
print( "<BR>\n" );

// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );

?>
<!-- ここまででPHPのスクリプト終わり -->

<BR>

出版社名：
<INPUT TYPE="text" SIZE="20" NAME="name">
　
出版社のホームページ：
<INPUT TYPE="url" NAME="homepage">

<BR><BR>
<INPUT TYPE="submit" VALUE="送信"><BR>

<BR>
<A HREF="publisher_list.php">出版社一覧に戻る</A>

</FORM>

</BODY>
</HTML>