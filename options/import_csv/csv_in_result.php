<?php 
	require_once('../../db_control.php');
	$result = 0;
	$name = time();
	$uploadfile = './csv/' . basename($name . '.csv');
	move_uploaded_file($_FILES['csv']['tmp_name'], $uploadfile);

	$file = new SplFileObject("./csv/" . $name . ".csv");
	$file->setFlags(SplFileObject::READ_CSV);

	foreach ($file as $line) {
		$db = exists_db($line[1]);
		if (empty($line[0]) || empty($db)){
			if(mb_strlen($line[1]) >= 3 && mb_strlen($line[1]) <= 10 && preg_match("/^[a-zA-Z0-9]+$/", $line[1])){
	            if(mb_strlen($line[2]) >= 3 && mb_strlen($line[2]) <= 10 && preg_match("/^[a-zA-Z0-9]+$/", $line[2])){
	                if(mb_strlen($line[3]) >= 1 && mb_strlen($line[3]) <= 20 && preg_match("/^[a-zA-Z0-9]+$/", $line[3])){
	                    continue;
	                }else{
	                	$result = 1;
	                }
	            }else{
	            	$result = 1;
	            }
	        }else{
	        	$result = 1;
	        }
		}else{
			$result = 1;
		}
	}
	
	if($result == 0){
		foreach ($file as $line){
			if (empty($line[0])){
			    continue; 
			}
			$id = $line[1];
			$passwd = $line[2];
			$name = $line[3];
			add_db($id, $passwd, $name);
		}
		$message = "CSVファイルを取り込みました。";
	}else{
		$message = "エラー";
	}

	
 ?>


 <!DOCTYPE html>
 <html>
 <head>
 	<title>CSV取り込み完了</title>
 	<meta charset="utf-8">
 </head>
 <body>
 	<h1><?php echo $message ?></h1>
 	<a href="../index_op.html">メニュー</a>
 </body>
 </html>