<!DOCTYPE html>
<html>
<head>
	<title>CSVインポート</title>
	<meta charset="utf-8">
</head>
<body>
	<h1>CSVインポート</h1>
	<form action="./csv_in_result.php" method="post" enctype="multipart/form-data">
		<label>アカウント情報：</label><input type="file" name="csv" accept=".csv" required><br>
		<button>登録</button><br>
	</form>	
	<a href="../index_op.html">戻る</a>
</body>
</html>