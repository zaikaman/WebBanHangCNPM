<div class="main_content">
  <div class="cart_content">
    <div class="wrapper-2">
      <div class="arrow-steps clearfix">
        <div class="step done"> <span> <a href="index.php?quanly=giohang"> Giỏ hàng</a></span> </div>
        <div class="step current"> <span><a href="index.php?quanly=vanChuyen"> Vận chuyển</a></span> </div>
        <div class="step "> <span><a href="index.php?quanly=thongTinThanhToan">Thanh toán</a></span> </div>
        <div class="step "> <span><a href="index.php?quanly=lichSuDonHang">Lịch sử</a></span> </div>
      </div>
    </div>
    <h4 class="title-vanchuyen">THÔNG TIN VẬN CHUYỂN</h4>
    <?php
    if (isset($_POST['themvanchuyen'])) {
      $name = $_POST['name'];
      $phone = $_POST['phone'];
      $address = $_POST['address'];
      $note = $_POST['note'];
      $id_dangky = $_SESSION['id_khachhang'];
      $sql_them_vanchuyen = mysqli_query($mysqli, "INSERT INTO tbl_giaohang(name,phone,address,note,id_dangky) VALUES ('$name','$phone','$address','$note','$id_dangky')");
      if ($sql_them_vanchuyen) {
        echo '<script>alert("Thêm thông tin vận chuyển thành công!")</script>';
      }
    } else if (isset($_POST['capnhatvanchuyen'])) {
      $name = $_POST['name'];
      $phone = $_POST['phone'];
      $address = $_POST['address'];
      $note = $_POST['note'];
      $id_dangky = $_SESSION['id_khachhang'];
      $sql_update_vanchuyen = mysqli_query($mysqli, "UPDATE tbl_giaohang SET name='$name', phone ='$phone', address='$address', note ='$note', id_dangky='$id_dangky' WHERE id_dangky='$id_dangky'");
      if ($sql_update_vanchuyen) {
        echo '<script>alert("Cập nhật thông tin vận chuyển thành công!")</script>';
      }
    }
    ?>
    <div class="row">
  <div class="col-md-12"></div>
  <form id="shippingForm" action="" autocomplete="off" method="POST" style="margin-bottom: 20px; margin-top: 20px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
    <div class="form-group">
      <label for="name">Họ và tên: </label>
      <input type="text" id="name" name="name" class="form-control" value="<?php echo $name ?>" placeholder="....">
      <span id="nameError" style="color: red;"></span>
    </div>
    <div class="form-group">
      <label for="phone">Số điện thoại:</label>
      <div style="display: flex; gap: 10px; align-items: center;">
        <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $phone ?>" placeholder="....">
        <button type="button" id="sendOtpButton" class="btn btn-secondary">Gửi OTP</button>
      </div>
      <span id="phoneError" style="color: red;"></span>
      <div class="form-group" id="otpField" style="display: none;">
        <label for="otp">Nhập OTP:</label>
        <input type="text" id="otp" name="otp" class="form-control" placeholder="...." maxlength="6">
        <span id="otpError" style="color: red;"></span>
      </div>
    </div>
    <div class="form-group">
      <label for="address">Địa chỉ:</label>
      <input type="text" id="address" name="address" class="form-control" value="<?php echo $address ?>" placeholder="....">
      <span id="addressError" style="color: red;"></span>
    </div>
    <div class="form-group">
      <label for="note">Ghi chú:</label>
      <input type="text" name="note" class="form-control" value="<?php echo $note ?>" placeholder="....">
    </div>
    <div style="display: flex; flex-direction: row; align-items: center; width: auto; gap: 20px;">
      <?php
      if ($name == '' && $phone == '') {
      ?>
        <button type="submit" name="themvanchuyen" class="btn btn-primary">Thêm vận chuyển</button>
      <?php
      } else if ($name != '' && $phone != '') {
      ?>
        <button type="submit" name="capnhatvanchuyen" class="dathang_button">Cập nhật vận chuyển</button>
      <?php
      }
      ?>
      <a href="index.php?quanly=thongTinThanhToan" id="checkoutButton" class="dathang_button">Thanh toán</a>
    </div>
  </form>
</div>
</div>
</div>

<script>
  // Hàm kiểm tra tính hợp lệ của form
  function validateForm() {
    let valid = true;
    let name = document.getElementById('name').value.trim();
    let phone = document.getElementById('phone').value.trim();
    let address = document.getElementById('address').value.trim();
    // Xóa các thông báo lỗi trước đó
    document.getElementById('nameError').innerText = '';
    document.getElementById('phoneError').innerText = '';
    document.getElementById('addressError').innerText = '';
    // Kiểm tra các trường bắt buộc
    if (name === '') {
      document.getElementById('nameError').innerText = 'Vui lòng nhập họ và tên.';
      valid = false;
    }
    if (phone === '') {
      document.getElementById('phoneError').innerText = 'Vui lòng nhập số điện thoại.';
      valid = false;
    } else if (!/^0\d{9}$/.test(phone)) { // Kiểm tra định dạng số điện thoại
      document.getElementById('phoneError').innerText = 'Số điện thoại sai định dạng, vui lòng nhập đúng số điện thoại bạn đang dùng.';
      valid = false;
    }
    if (address === '') {
      document.getElementById('addressError').innerText = 'Vui lòng nhập địa chỉ.';
      valid = false;
    }
    return valid;
  }
  
  // Kiểm tra khi nhấn vào nút "Cập nhật vận chuyển"
  document.getElementById('shippingForm').addEventListener('submit', function (e) {
    if (!validateForm()) {
      e.preventDefault();
    }
  });

  // Kiểm tra khi nhấn vào nút "Thanh toán"
  document.getElementById('checkoutButton').addEventListener('click', function (e) {
    if (!validateForm()) {
      e.preventDefault();
    }
  });
  document.getElementById('sendOtpButton').addEventListener('click', function () {
    // Display the OTP field
    document.getElementById('otpField').style.display = 'block';
  });
</script>



