<?php 
	header("Content-Type:text/html;charset=utf8");

	$number = $_POST['Num'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$password2 = $_POST['password'];
	$email = $_POST['email'];

	if ($username == '') {
		exit("用户名不能为空！");
	}
	if ($password!=$password2) {
		exit("两次输入密码不一致！");
	}


	$server = "localhost";
	$user = "root";
	$pwd = "12345678";
	$dbname = "school";
	$connection = mysqli_connect($server,$user,$pwd);


	if ($connection) {
		$password = md5($password);
		mysqli_select_db($connection,$dbname);
		$sql1 = "SELECT UserName FROM adminInfo WHERE UserName = '$username'";
		$result = mysqli_query($connection,$sql1);
		if (mysqli_num_rows($result)>0) {
			exit('用户名已被使用！');
		}else{
			$sql2 = "INSERT INTO adminInfo (Num,UserName,Password,Email) VALUES ('$number','$username','$password','$email')";                                   
			$result = mysqli_query($connection,$sql2);
			if ($result) {
				echo "注册成功！3s后自动跳转到登陆页面";
				$url = "http://127.0.0.1/websys/login.html";
				echo "<script language='javascript' 
				type='text/javascript'>";  
				echo "setTimeout(function(){window.location.href='$url'},3000)";  
				echo "</script>";  

			}else{
				die("注册失败！");
			}
		}
	}
 ?>
