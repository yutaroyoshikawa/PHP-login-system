<?php 
function connect_db(){
	 try {
     $pdo = new PDO('mysql:host=localhost;dbname=ph22_kadai06_ih12b335_16;charset=utf8', 'root', 'root',
         array(PDO::ATTR_EMULATE_PREPARES => false));
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 } catch (PDOException $e) {
	     exit('データベース接続失敗。'.$e->getMessage());
	 }

	 return $pdo;
}

function exists_db($id = null, $passwd = null){
	$pdo = connect_db();

	if(!($id == null) && $passwd == null){
		$stmt = $pdo->prepare("SELECT * FROM accounts WHERE login_id = :id");
	 	$stmt->bindParam(':id', $id);
	}else if(!($id == null) && !($passwd == null)){
		$stmt = $pdo->prepare("SELECT * FROM accounts WHERE login_id = :id AND password = :passwd;");
	 	$stmt->bindParam(':id', $id);
	 	$stmt->bindParam(':passwd', $passwd);
	}else if($id == null && $passwd == null){
		$stmt = $pdo->prepare("SELECT * FROM accounts;");
	}
	
 	$stmt->execute();
 	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;

    return $result;
}

function change_db($login_id, $id = null, $passwd = null, $name = null){
	$pdo = connect_db();
	// id null
	// passwd ?
	// name ?
	if($id == null || $id == ''){
		if($passwd == null || $passwd == ''){
			if($name == null || $name == ''){
				$pdo = null;
				return 1;
			}
		}

		if($name == null || $name == ''){
			$stmt = $pdo->prepare("UPDATE accounts SET password = :passwd WHERE login_id = :login_id;");
			$stmt->bindParam(':passwd', $passwd);
	 		$stmt->bindParam(':login_id', $login_id);
	 		$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$pdo = null;
			return 0;
		}else{
			$stmt = $pdo->prepare("UPDATE accounts SET name = :name WHERE login_id = :login_id;");
			$stmt->bindParam(':name', $name);
	 		$stmt->bindParam(':login_id', $login_id);
	 		$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$pdo = null;
			return 0;
		}
	}

	// id exist
	// passwd null
	// name ?
	if($passwd == null || $passwd == ''){
		// name null
		if($name == null || $name == ''){
			if(empty($exists) || $login_id == $id){
				$stmt = $pdo->prepare("UPDATE accounts SET login_id = :id WHERE login_id = :login_id;");
				$stmt->bindParam(':id', $id);
		 		$stmt->bindParam(':login_id', $login_id);
		 		$stmt->execute();
			 	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			    $pdo = null;
			    session_start();
			    $_SESSION['id'] = $id;
			    setcookie ("id", $id, time()+1000);
			    return 0;
			}else{
				$pdo = null;
				return 1;
			}
		}else{
		// name exist
			if(empty($exists) || $login_id == $id){
				$stmt = $pdo->prepare("UPDATE accounts SET login_id = :id, name = :name WHERE login_id = :login_id;");
				$stmt->bindParam(':id', $id);
				$stmt->bindParam(':name', $name);
		 		$stmt->bindParam(':login_id', $login_id);
		 		$stmt->execute();
			 	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			    $pdo = null;
			    session_start();
			    $_SESSION['id'] = $id;
			    setcookie ("id", $id, time()+1000);
			    return 0;
			}else{
				$pdo = null;
				return 1;
			}
		}
	}

	// id exist
	// passwd exist
	// name null
	if($name == null || $name == ''){
		$exists = exists_db($id);
		if(empty($exists) || $login_id == $id){
			$stmt = $pdo->prepare("UPDATE accounts SET login_id = :login_id, password = :passwd WHERE login_id = :login_id;");
			$stmt->bindParam(':passwd', $passwd);
	 		$stmt->bindParam(':login_id', $login_id);
	 		$stmt->execute();
		 	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    $pdo = null;
		    session_start();
			$_SESSION['id'] = $id;
			setcookie ("id", $id, time()+1000);
		    return 0;
		}else{
			$pdo = null;
			return 1;
		}
	}


	$exists = exists_db($id);
	if(empty($exists) || $login_id == $id){
		$stmt = $pdo->prepare("UPDATE accounts SET login_id = :id, password = :passwd, name = :name WHERE login_id = :login_id;");
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':passwd', $passwd);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':login_id', $login_id);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$pdo = null;
		session_start();
		$_SESSION['id'] = $id;
		setcookie ("id", $id, time()+1000);
		return 0;
	}else{
		$pdo = null;
		return 1;
	}	
}

function add_db($id, $passwd, $name){
	$pdo = connect_db();
	$stmt = $pdo->prepare("INSERT INTO accounts(login_id, password, name) VALUES (:login_id, :passwd, :name);");
	$stmt->bindParam(':login_id', $id);
	$stmt->bindParam(':passwd', $passwd);
	$stmt->bindParam(':name', $name);
	$stmt->execute();
}

function export_db(){
	$db = exists_db();
	foreach ($db as $culm => $value) {
		$input .= $value['id'] . "," . $value['login_id'] . "," . $value['password'] . ",\"" . $value['name'] . "\"\n";
	}

	$filename = "./csv/" . time() . ".csv";

	$fp = @fopen($filename, "w") or die("Error!!n");
  	fputs($fp, $input);
  	fclose($fp);

 	//header('Content-Type: application/octet-stream');
	// header('Content-Disposition: attachment; filename=export_csv.csv'); 
	// header('Content-Transfer-Encoding: binary');
	// header('Content-Length: ' . filesize($filename));
	// readfile($filename);

	return $filename;
}
?>