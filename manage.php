<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<title>学生成员管理</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<h2 class="admin">你好!管理员
		<?php 
		if (!isset($_SESSION)) {
			session_start();
		}
		echo $_SESSION['UID'];
		?>
	</h2>
	<a href="javascript:window.location.href='index.html'" class="exit">退出登录</a>

	<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<p><span>学号：</span><input type='text' name="studentid"></p>
		<p><span>密码：</span><input type='text' name="password"></p>
		<p><span>班级：</span><input type='text' name="classnum"></p>
		<p class="name"><span>学生姓名：</span><input type='text' name="name"></p>
		<p class="tel"><span>联系方式：</span><input type='text' name="phone"></p>
		<input type='submit' value="添加" name="add" class="button">
		<input type="submit" value="查询" name="find">
		<input type="reset" value="重置">
	</form>

	<?php 
		header("Content-Type:text/html;charset=utf8");
		$server = "localhost";
		$user = "root";
		$pwd = "12345678";
		$dbname = "school";
		$connection = mysqli_connect($server,$user,$pwd);

		if (isset($_POST['add'])) {
			$studentid = $_POST['studentid'];
			$classNum = $_POST['classnum'];
			$password = $_POST['password'];
			$studentName = $_POST['name'];
			$phone = $_POST['phone'];		
			if ($studentid == "") {
				exit("<p class='tipnum tip'>学号不能为空！</p>");
			}
			if ($studentName =="") {
				exit("<p class='tipname tip'>姓名不能为空！</p>");
			}
			if ($connection) {
				$password = md5($password);
				mysqli_select_db($connection,$dbname);
				$sql1 = "SELECT studentID FROM studentInfo WHERE studentID = '$studentid'";
				$result = mysqli_query($connection,$sql1);
				if (mysqli_num_rows($result)>0) {
					exit('<p class="tips">该学生已注册过！</p>');
				}else{
					$sql2 = "INSERT INTO studentInfo (studentID,Password,Name,Class,Phone) VALUES ('$studentid','$password','$studentName','$classNum','$phone')";                                   
					$result = mysqli_query($connection,$sql2);
					if ($result) {	 
						echo "<p class='success'>添加成功</p>";
						
					}else{
						die("注册失败！");
					}
				}
			}
			
		}
		if (isset($_POST['find'])) {
			echo "
			<table>
				<tr>
					<th>学号</th>
					<th>班级</th>
					<th>姓名</th>
					<th>联系方式</th>
					<th>操作</th>";
			if ($connection) {
				$studentid = $_POST['studentid'];
				$classNum = $_POST['classnum'];
				$password = $_POST['password'];
				$studentName = $_POST['name'];
				$phone = $_POST['phone'];
				mysqli_select_db($connection,$dbname);
				if ($studentid>0) {
					$sql = "SELECT * FROM studentInfo WHERE studentID = '$studentid'";
					$result = mysqli_query($connection,$sql);
				}
				elseif ($classNum>0) {
					$sql = "SELECT * FROM studentInfo WHERE Class = '$classNum'";
					$result = mysqli_query($connection,$sql);
				}
				elseif ($studentName>0) {
					$sql = "SELECT * FROM studentInfo WHERE Name = '$studentName'";
					$result = mysqli_query($connection,$sql);
				}else{
					exit("<p class='tip tipcheck'>请输入学号或班级！</p>");
				}			
				
				if ($result) {
					$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
					if($row){
						echo "
							<tr id='msg'>
								<td id='stdid'>".$row['studentID']."</td>
								<td>".$row['Class']."</td>
								<td>".$row['Name']."</td>
								<td>".$row['Phone']."</td>
								<td><a href='javascript:void(0)'class='del' id='del'>删除</a></td>
							</tr>
						</table>";
					}else{
						echo "<p class='tips'>该学生未被添加</p>";
					}
				}else{
					die("查询失败！");
				}
			}
		}
	 ?>
	 <script type="text/javascript">
	 	var del = document.getElementById('del'),
	 		msg = document.getElementById('msg'),
	 		studentid = document.getElementById('stdid').innerHTML,
	 		xmlHttp = new XMLHttpRequest();
	 	del.onclick = function(){
	 		msg.parentNode.removeChild(msg);
	 		window.location.href="?click="+studentid;
		
	 	}
	 </script>
	 <?php 
	 	if (isset($_GET['click'])) {
	 		$studentid = $_GET['click'];
	 		$server = "localhost";
	 		$user = "root";
	 		$pwd = "12345678";
	 		$dbname = "school";
	 		$connection = mysqli_connect($server,$user,$pwd);
	 		if ($connection) {
	 			mysqli_select_db($connection,$dbname);
	 			$sql = "DELETE FROM studentInfo WHERE studentID = '$studentid'";
	 			$result = mysqli_query($connection,$sql);
	 		}
	 	}
	  ?>
</body>
</html>