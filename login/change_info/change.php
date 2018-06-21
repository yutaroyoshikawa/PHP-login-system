<?php 
require_once('../../db_control.php');
session_start();
$session = $_SESSION['id'];
if(empty($session)){
	$message = 'ログインしてください。';
}else{
	$loginInfo = exists_db($session);
	$id = $loginInfo[0]['login_id'];
	$passwd = $loginInfo[0]['password'];
	$name = $loginInfo[0]['name'];
	$message = 'ログイン情報変更';
	$html = <<< EOF
			<form action="./change_check.php" method="post">
				<input type="text" value="{$id}" readonly><input type="password" value="{$passwd}" readonly><input type="text" value="{$name}" readonly><br>
				<input type="text" name="id"><input type="password" name="passwd"><input type="text" name="name"><br>
				<button>変更</button>
			</form>
EOF;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>ログイン情報変更</title>
	<meta charset="utf-8">
</head>
<body>
	<h1><?php echo $message ?></h1>
	<?php echo $html ?>
	<a href="../welcome.php">戻る</a><br>
	<a href="../../index.html">メニュー</a>
</body>
</html>