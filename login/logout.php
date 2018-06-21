<?php 
session_start();
setcookie ("id", $_SESSION['id'], time()+1000);
session_destroy();
header('Location: ../index.html', true, 301);
 ?>