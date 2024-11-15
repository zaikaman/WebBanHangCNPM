<div class="main_content">
  <div class="cart_content">
    <div class="wrapper-2">
      <div class="arrow-steps clearfix">
        <div class="step done"> <span> <a href="index.php?quanly=giohang" data-ajax="true"> Giỏ hàng</a></span> </div>
        <div class="step current"> <span><a href="index.php?quanly=vanChuyen" data-ajax="true"> Vận chuyển</a></span> </div>
        <div class="step "> <span><a href="index.php?quanly=thongTinThanhToan" data-ajax="true">Thanh toán</a></span> </div>
        <div class="step "> <span><a href="index.php?quanly=lichSuDonHang" data-ajax="true">Lịch sử</a></span> </div>
      </div>
    </div>
    <h4 class="title-vanchuyen">THÔNG TIN VẬN CHUYỂN</h4>
    <div class="row vanchuyen-form">
      <?php
      $id_dangky = $_SESSION['id_khachhang'];
      $sql_get_vanchuyen = mysqli_query($mysqli, "SELECT * FROM tbl_giaohang WHERE id_dangky='$id_dangky' LIMIT 1");
      $count = mysqli_num_rows($sql_get_vanchuyen);
      if ($count > 0) {
        $row_get_vanchuyen = mysqli_fetch_array($sql_get_vanchuyen);
        $name = $row_get_vanchuyen['name'];
        $phone = $row_get_vanchuyen['phone'];
        $address = $row_get_vanchuyen['address'];
        $note = $row_get_vanchuyen['note'];
      } else {
        $name = '';
        $phone = '';
        $address = '';
        $note = '';
      }
      ?>
      <form action="pages/main/xuly_vanchuyen.php" method="POST" id="shippingForm" data-ajax="true" data-validate="true">
        <div class="form-group">
          <div style="width : 100%; display : flex; flex-direction : row;  justify-content: center;
              align-items: center;">
            <label for="name">Họ và tên: </label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo $name ?>" placeholder="....">
          </div>
          <span id="nameError" style="color: red;"></span>
        </div>
        <div class="form-group">
          <div style="width : 100%; display : flex; flex-direction : row;  justify-content: center;
  align-items: center;">
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $phone ?>" placeholder="....">
          </div>
          <span id="phoneError" style="color: red;"></span>
        </div>
        <div class="form-group">
          <div style="width : 100%; display : flex; flex-direction : row;  justify-content: center;
  align-items: center;">
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address" class="form-control" value="<?php echo $address ?>" placeholder="....">
          </div>
          <span id="addressError" style="color: red;"></span>
        </div>
        <div class="form-group">
          <div style="width : 100%; display : flex; flex-direction : row;  justify-content: center;
  align-items: center;">
            <label for="note">Ghi chú:</label>
            <input type="text" name="note" class="form-control" value="<?php echo $note ?>" placeholder="....">
          </div>
        </div>
        <div style="display: flex; flex-direction: row; align-items: center; width: auto; gap : 20px">
          <?php
          if ($name == '' && $phone == '') {
          ?>
            <button type="submit" name="themvanchuyen" class="dathang_button">Thêm vận chuyển</button>
          <?php
          } else if ($name != '' && $phone != '') {
          ?>
            <button type="submit" name="capnhatvanchuyen" class="dathang_button">Cập nhật vận chuyển</button>
          <?php
          }
          ?>
          <a href="index.php?quanly=thongTinThanhToan" id="checkoutButton" class="dathang_button" data-ajax="true">Thanh toán</a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    // Hàm validate form
    window.validateForm = function(form) {
        let valid = true;
        let name = $('#name').val().trim();
        let phone = $('#phone').val().trim();
        let address = $('#address').val().trim();

        // Xóa các thông báo lỗi trước đó
        $('#nameError').text('');
        $('#phoneError').text('');
        $('#addressError').text('');

        // Kiểm tra các trường bắt buộc
        if (name === '') {
            $('#nameError').text('Vui lòng nhập họ và tên.');
            valid = false;
        }
        if (phone === '') {
            $('#phoneError').text('Vui lòng nhập số điện thoại.');
            valid = false;
        } else if (!/^0\d{9}$/.test(phone)) {
            $('#phoneError').text('Số điện thoại sai định dạng, vui lòng nhập đúng số điện thoại bạn đang dùng.');
            valid = false;
        }
        if (address === '') {
            $('#addressError').text('Vui lòng nhập địa chỉ.');
            valid = false;
        }
        return valid;
    };

    // Kiểm tra khi nhấn vào nút "Thanh toán"
    $('#checkoutButton').on('click', function(e) {
        if (!validateForm()) {
            e.preventDefault();
        }
    });
});
</script>
