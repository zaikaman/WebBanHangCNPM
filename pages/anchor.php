<div class="anchor">
    <a href="#header">
        <img style="  width: 27px;
        height: 30px;" src="../images/anchor.svg" alt="">
    </a>
</div>



<div id="registration_success" class="registration_success">
    <p style="color:white">Đăng ký thành công !!!</p>
</div>
<div id="registration_success2" class="registration_success2">
    <p style="color:white">Thêm thành công !!!</p>
</div>
<div id="registration_success3" class="registration_success2">
    <p style="color:white">Đổi mật khẩu thành công !!!</p>
</div>
<div id="user_notfound" class="user_notfound">
    <p style="color:white">Vui lòng đăng nhập !!!</p>
</div>




<script>
    <?php if (isset($_GET['registration']) && $_GET['registration'] == 1): ?>
        document.addEventListener("DOMContentLoaded", function() {
            var registration_success = document.getElementById("registration_success");
            setTimeout(function() {
                registration_success.classList.add('active');
            }, 10);
            setTimeout(function() {
                registration_success.classList.remove('active');
            }, 5000);
        });
    <?php endif; ?>
</script>
<script>
    <?php if (isset($_GET['additem_success']) && $_GET['additem_success'] == 1): ?>
        document.addEventListener("DOMContentLoaded", function() {
            var registration_success = document.getElementById("registration_success2");
            setTimeout(function() {
                registration_success.classList.add('active');
            }, 100);
            setTimeout(function() {
                registration_success.classList.remove('active');
            }, 5000);
        });
    <?php endif; ?>
</script>
<script>
    <?php if (isset($_GET['changepassword']) && $_GET['changepassword'] == 1): ?>
        document.addEventListener("DOMContentLoaded", function() {
            var registration_success = document.getElementById("registration_success3");
            setTimeout(function() {
                registration_success.classList.add('active');
            }, 100);
            setTimeout(function() {
                registration_success.classList.remove('active');
            }, 5000);
        });
    <?php endif; ?>
</script>
<script>
    <?php if (isset($_GET['user_notfound']) && $_GET['user_notfound'] == 1): ?>
        document.addEventListener("DOMContentLoaded", function() {
            var user_notfound = document.getElementById("user_notfound");
            setTimeout(function() {
                user_notfound.classList.add('active');
            }, 100);
            setTimeout(function() {
                user_notfound.classList.remove('active');
            }, 5000);
        });
    <?php endif; ?>
</script>
