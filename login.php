<?php 
	header("Content-Type:text/html;charset=utf8");

	$username = $_POST['username'];
	$password = $_POST['password'];

	$server = "localhost";
	$user = "root";
	$pwd = "";
	$dbname = "shopping";
	$connection = mysqli_connect($server,$user,$pwd);
	if ($connection) {
		
		$password = md5($password);
		mysqli_select_db($connection,$dbname);

		$sql = "SELECT UserName,Password FROM adminInfo WHERE UserName = '$username' AND Password = '$password'";
		$result = mysqli_query($connection,$sql);
		if ($result) {
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			if($row){
				session_start();
				$_SESSION['UID'] = $row['UserName'];
				echo "登录成功,3s后跳转到管理页面";
				$url = "http://127.0.0.1/websys/manage.php";
				echo "<script language='javascript' 
				type='text/javascript'>";  
				echo "setTimeout(function(){window.location.href='$url'},3000)";  
				echo "</script>";
			}else{
				echo "用户名或密码不正确";
			}
		}else{
			die("登录失败！");
		}
	}
 ?>