<?php
	session_start();
include('config/config.php');

if (isset($_POST['dangNhap'])) {
    $taikhoan = $_POST['username'];
    $matkhau = md5($_POST['password']);

    // Chuẩn bị câu lệnh SQL
    $stmt = $mysqli->prepare("SELECT * FROM tbl_admin WHERE user_name = ? AND password = ?");
    $stmt->bind_param("ss", $taikhoan, $matkhau); // "ss" nghĩa là hai tham số kiểu chuỗi

    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;

    if ($count > 0) {
        $_SESSION['dangNhap'] = $taikhoan;
        header("Location:index.php");
    } else {
        echo '<p class="text-danger text-center mt-3">Tài khoản hoặc mật khẩu không đúng, vui lòng nhập lại</p>';
        header('Location:login.php');
    }

    $stmt->close();
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Admin</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style type="text/css">
    	body{
    		background: #f2f2f2;
    	}
    	.wrapper_login {
    		margin: 0 auto;
    		width: 100%;
    		max-width: 400px;
    		padding-top: 50px;
    	}
    </style>
</head>
<body>
	<div class="wrapper_login">
		<div class="card">
			<div class="card-header text-center">
				<h3>ĐĂNG NHẬP ADMIN</h3>
			</div>
			<div class="card-body">
				<form action="" autocomplete="off" method="POST">
					<div class="form-group">
						<label for="username">Tài Khoản</label>
						<input type="text" name="username" class="form-control" id="username" placeholder="Nhập tài khoản" required>
					</div>
					<div class="form-group">
						<label for="password">Mật Khẩu</label>
						<input type="password" name="password" class="form-control" id="password" placeholder="Nhập mật khẩu" required>
					</div>
					<button type="submit" name="dangNhap" class="btn btn-primary btn-block">ĐĂNG NHẬP</button>
				</form>
			</div>
		</div>
	</div>

	<!-- Bootstrap JS, Popper.js, and jQuery -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>	
</html>
