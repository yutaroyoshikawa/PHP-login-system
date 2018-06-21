<?php 
require_once('../db_control.php');
session_start();
$id = $_SESSION['id'];
$result = exists_db($id);

if(empty($result)){
	$message = "ログインしてください。";
	$log = '<li><a href="./login.php">ログイン</a></li>';
	$userinfo = '';
}else{
	$name = $result[0]['name'];
	$message = 'ようこそ、' . $name . 'さん。';
	$log = '<li><a href="./logout.php">ログアウト</a></li>';
	$userinfo = '<li><a href="./change_info/change.php">ユーザー情報変更（オプション）</a></li>';
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>ようこそ</title>
	<meta charset="utf-8">
</head>
<body>
	<h1><?php echo $message ?></h1>
	<ul>
		<?php echo $userinfo ?>
		<?php echo $log ?>
		<li><a href="../index.html">メニュー</a></li>
	</ul>
</body>
</html>