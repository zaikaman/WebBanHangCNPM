<?php
session_start();

// Assuming the user's email is stored in the session after registration
if (isset($_SESSION['email'])) {
    $user_email = htmlspecialchars($_SESSION['email']); // Xử lý dữ liệu để tránh XSS
} else {
    // Fallback in case the email is not set
    $user_email = 'your-email@example.com';
}

// Logic to handle resend email functionality
if (isset($_POST['resend_email'])) {
    // You would add logic here to resend the email
    // For example, you might send the verification email again using a mail function or email API

    // Example of feedback after resending the email
    $resend_message = "A verification email has been resent to " . $user_email;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .verification-container {
            background-color: white;
            text-align: center;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .verification-container img {
            width: 60px;
            height: 60px;
        }
        .verification-container h1 {
            font-size: 24px;
            margin-top: 20px;
        }
        .verification-container p {
            font-size: 16px;
            color: #666;
            margin: 10px 0;
        }
        .verification-container .highlight {
            font-weight: bold;
            color: #4a4a4a;
        }
        .verification-container .buttons {
            margin-top: 20px;
        }
        .verification-container .buttons form {
            display: inline-block;
        }
        .verification-container .buttons input {
            text-decoration: none;
            background-color: #a270f6;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            margin: 5px;
        }
        .verification-container .buttons a {
            text-decoration: none;
            background-color: #a270f6;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 5px;
            display: inline-block;
        }
        .verification-container .buttons input:hover,
        .verification-container .buttons a:hover {
            background-color: #915ed6;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }
        .resend-message {
            margin-top: 15px;
            color: green;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <img src="assets/images/email_icon.png" alt="Email Icon"> <!-- Replace this with your actual image path -->
        <h1>Verify your email address</h1>
        <p>We have sent a verification link to <span class="highlight"><?php echo $user_email; ?></span>.</p>
        <p>Click on the link to complete the verification process. You might need to check your spam folder.</p>
        
        <div class="buttons">
            <form action="" method="POST">
                <input type="submit" name="resend_email" value="Resend email">
            </form>
            <a href="index.php">Return to Site</a>
        </div>
        
        <?php if (isset($resend_message)): ?>
            <div class="resend-message">
                <?php echo $resend_message; ?>
            </div>
        <?php endif; ?>

        <div class="footer">
            You can reach us if you have any questions.
        </div>
    </div>
</body>
</html>
