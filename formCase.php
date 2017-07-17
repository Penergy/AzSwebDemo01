<?php 
require "include.php";
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
	case 'GET':
		# code...
		// $users = getUserList();
		break;
	case 'POST':
		# code...
		echo $_POST["username"]; 
		echo $_POST["email"]; 
		$formData = $_POST;
		$flag = insertUser($formData, $conn);
		// print_r($flag);
		// $users = getUserList();
		break;
	default:
		# code...
		break;
}

?>
<html>
<head>
<meta charset="utf-8">
<title>菜鸟教程(runoob.com)</title>
</head>
<body>
 
<form action="formCase.php" method="post">
名字: <input type="text" name="username">
年龄: <input type="text" name="email">
<input type="submit" value="提交">
</form>
 
</body>
</html>