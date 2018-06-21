<?php 
	session_start();
	$session = $_SESSION['id'];
	if(!empty($session)){
		header('Location: ./welcome.php', true, 301);
	}
	if(!empty($_COOKIE['id'])){
		$id = $_COOKIE['id'];
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>ログイン</title>
	<meta charset="utf-8">
</head>
<body>
	<form action="./login_check.php" method="post">
		<label>ログインID：</label><input type="text" name="id" value="<?php echo $id ?>" required><br>
		<label>パスワード：</label><input type="password" name="passwd" required><br>
		<button>ログイン</button><br>
	</form>
	<a href="../index.html">メニュー</a>
</body>
</html>