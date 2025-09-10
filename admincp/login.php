<?php
session_start();
include('config/config.php');

$error_message = '';

if (isset($_POST['dangNhap'])) {
    $taikhoan = $_POST['username'];
    $matkhau = md5($_POST['password']);

    // Chuẩn bị câu lệnh SQL
    $stmt = $mysqli->prepare("SELECT * FROM tbl_admin WHERE user_name = ? AND password = ?");
    if (!$stmt) {
        $error_message = 'Database prepare error: ' . $mysqli->error;
    } else {
        $stmt->bind_param("ss", $taikhoan, $matkhau);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->num_rows;

        if ($count > 0) {
            $_SESSION['dangNhap'] = $taikhoan;
            header("Location: index.php");
            exit();
        } else {
            $error_message = 'Tài khoản hoặc mật khẩu không đúng!';
        }
        $stmt->close();
    }
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>7TCC Admin - Đăng Nhập</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon_io/favicon-32x32.png">
    
    <style type="text/css">
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #dc0021 0%, #a90019 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-header {
            background: linear-gradient(135deg, #dc0021 0%, #a90019 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        
        .login-header img {
            max-width: 120px;
            height: auto;
            margin-bottom: 15px;
            filter: brightness(0) invert(1);
        }
        
        .login-header h3 {
            font-weight: 700;
            font-size: 24px;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .login-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-weight: 400;
        }
        
        .login-body {
            padding: 40px 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 15px 20px;
            padding-left: 50px;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }
        
        .form-control:focus {
            border-color: #dc0021;
            box-shadow: 0 0 0 0.2rem rgba(220, 0, 33, 0.25);
            background-color: #fff;
            outline: none;
        }
        
        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #dc0021;
            font-size: 16px;
            z-index: 5;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #dc0021 0%, #a90019 100%);
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-weight: 700;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, #a90019 0%, #dc0021 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 0, 33, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .error-message {
            background: linear-gradient(135deg, #ff4757 0%, #ff3742 100%);
            color: white;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 500;
            text-align: center;
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        .login-footer {
            text-align: center;
            padding: 20px 30px;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }
        
        .login-footer p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }
        
        @media (max-width: 576px) {
            .login-container {
                margin: 10px;
                border-radius: 15px;
            }
            
            .login-header, .login-body {
                padding: 30px 20px;
            }
            
            .login-header h3 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="../images/image7tcc2removebgpreview11884-0kr5-200h.png" alt="7TCC Logo">
            <h3>Admin Dashboard</h3>
            <p>Đăng nhập để quản lý hệ thống</p>
        </div>
        
        <div class="login-body">
            <?php if(!empty($error_message)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            
            <form action="" autocomplete="off" method="POST" id="loginForm">
                <div class="form-group">
                    <label for="username">
                        <i class="fas fa-user mr-2"></i>Tài Khoản
                    </label>
                    <div class="position-relative">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="username" class="form-control" id="username" 
                               placeholder="Nhập tài khoản admin" required autocomplete="username">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock mr-2"></i>Mật Khẩu
                    </label>
                    <div class="position-relative">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" class="form-control" id="password" 
                               placeholder="Nhập mật khẩu" required autocomplete="current-password">
                    </div>
                </div>
                
                <button type="submit" name="dangNhap" class="btn btn-login btn-block">
                    <i class="fas fa-sign-in-alt mr-2"></i>Đăng Nhập
                </button>
            </form>
        </div>
        
        <div class="login-footer">
            <p>
                <i class="fas fa-shield-alt mr-1"></i>
                Hệ thống quản lý 7TCC - Bảo mật cao
            </p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Auto-focus on username field
            $('#username').focus();
            
            // Focus effects for input icons
            $('.form-control').on('focus', function() {
                $(this).parent().find('.input-icon').css('color', '#dc0021');
            });
            
            $('.form-control').on('blur', function() {
                $(this).parent().find('.input-icon').css('color', '#dc0021');
            });
            
            // Remove the problematic form submit handler completely
            // Form will submit naturally without JavaScript interference
        });
    </script>
</body>	
</html>
