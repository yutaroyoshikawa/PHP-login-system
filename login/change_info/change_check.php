<?php 
require_once('../../db_control.php');

session_start();
$login_id = $_SESSION['id'];
$id = $_POST['id'];
$passwd = $_POST['passwd'];
$name = $_POST['name'];

$result = change_db($login_id, $id, $passwd, $name);
if ($result == 0) {
	header('Location: ./change_success.html', true, 301);
}else{
	header('Location: ./change_error.html', true, 301);
}


 ?>