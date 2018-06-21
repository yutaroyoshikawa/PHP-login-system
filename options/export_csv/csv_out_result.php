<?php 
require_once('../../db_control.php');
 ?>
<!DOCTYPE html>
<html>
	<head>
		<title>CSVダウンロード</title>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>CSVファイルに出力しました。</h1>
		<a href="<?php echo export_db(); ?>" download="accounts.csv">CSVダウンロード</a><br>
		<a href="../index_op.html">メニュー</a>
	</body>
</html>