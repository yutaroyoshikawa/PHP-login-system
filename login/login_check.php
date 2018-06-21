<?php 
	require_once('../db_control.php');
	$id = $_POST['id'];
	$passwd = $_POST['passwd'];
	$result = exists_db($id, $passwd);

    if(!empty($result)){
    	session_start();
    	$_SESSION['id'] = $result[0]['login_id'];
    	// setcookie ("id", $id, time()+1000);
    	header('Location: ./welcome.php', true, 301);
    }else{
    	header('Location: ./login_error.html', true, 301);
    }

 ?>