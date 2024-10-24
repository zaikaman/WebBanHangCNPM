<?php
	session_start();
	include('config/config.php');
	if(isset($_POST['dangNhap'])){
		$taikhoan = $_POST['username'];
		$matkhau = md5($_POST['password']);
		$sql = "SELECT * FROM tbl_admin WHERE user_name = '".$taikhoan."' AND password = '".$matkhau."'";
		$row = mysqli_query($mysqli,$sql);
		$count = mysqli_num_rows($row);
		if($count > 0){
			$_SESSION['dangNhap'] = $taikhoan;
			header("Location:index.php");
		}else{
			echo '<p>Tài khoản hoặc mật khẩu không đúng, vui lòng nhập lại</p>';
			header('Location:login.php');
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DANG NHAP</title>
    <style type="text/css">
    	body{
    		background: #f2f2f2;
    	}
    	.wrapper_login {
    		margin: 0 auto;
    		width: 20%;
    	}
    	.table_login tr td{
    		padding: 5px;
    	}
    </style>
</head>
<body>
	<div class="wrapper_login">
		<form action="" autocomplete="off" method="POST">
		<table border="1" class="table_login" style="text-align: center; border-collapse: collapse;">
			<tr>
				<td colspan="2"><h3>ĐĂNG NHẬP ADMIN</h3></td>
			</tr>
			<tr>
				<td>Tài Khoản</td>
				<td><input type="text" name="username"></td>
			</tr>
			<tr>
				<td>Mật Khẩu</td>	
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<td colspan="2"><input type="Submit" name="dangNhap" value="ĐĂNG NHẬP"></td>
			</tr>
		</table>
		</form>
	</div>  
		
</body>	
</html>