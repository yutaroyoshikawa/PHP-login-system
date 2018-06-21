<?php 
	require_once('../db_control.php');
	$id = $_POST['id'];
	$passwd = $_POST['passwd'];
    $name = $_POST['name'];
	$result = exists_db($id);

    if(!empty($result)){
    	header('Location: ./regist_error.html', true, 301);
    }else{
        if(mb_strlen($id) >= 3 && mb_strlen($id) <= 10 && preg_match("/^[a-zA-Z0-9]+$/", $id)){
            if(mb_strlen($passwd) >= 3 && mb_strlen($passwd) <= 10 && preg_match("/^[a-zA-Z0-9]+$/", $passwd)){
                if(mb_strlen($name) >= 1 && mb_strlen($name) <= 20 && preg_match("/^[a-zA-Z0-9]+$/", $name)){
                    $pdo = connect_db();
                    $stmt = $pdo->prepare("INSERT INTO accounts(login_id, password, name) VALUES (:id, :passwd, :name);");
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':passwd', $passwd);
                    $stmt->bindParam(':name', $name);
                    $stmt->execute();
                    $pdo = null;
                    header('Location: ./regist_success.html', true, 301);
                }else{
                    header('Location: ./regist_error.html', true, 301);
                }
            }else{
                header('Location: ./regist_error.html', true, 301);
            }
        }else{
            header('Location: ./regist_error.html', true, 301);
        }
        
    }
 ?>