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
    <h4>THÔNG TIN VẬN CHUYỂN</h4>
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
      <div class="col-md-12"></div>
      <form action="" autocomplete="off" method="POST" style="margin-bottom : 20px; margin-top : 20px">
        <div class="form-group">
          <label for="email">Họ và tên: </label>
          <input type="text" name="name" class="form-control" value="<?php echo $name ?>" placeholder="....">
        </div>
        <div class="form-group">
          <label for="pwd">Số điện thoại:</label>
          <input type="text" name="phone" class="form-control" value="<?php echo $phone ?>" placeholder="....">
        </div>
        <div class="form-group">
          <label for="pwd">Địa chỉ:</label>
          <input type="text" name="address" class="form-control" value="<?php echo $address ?>" placeholder="....">
        </div>
        <div class="form-group">
          <label for="pwd">Ghi chú:</label>
          <input type="text" name="note" class="form-control" value="<?php echo $note ?>" placeholder="....">
        </div>
        <div style="display : flex; flex-direction : row; align-items : center; width : 100%">
          <?php
          if ($name == '' && $phone == '') {
          ?>
            <button type="submit" name="themvanchuyen" class="btn btn-primary">Thêm thông tin vận chuyển</button>
          <?php
          } else if ($name != '' && $phone != '') {
          ?>
            <button type="submit" name="capnhatvanchuyen" class="dathang_button">Cập nhật thông tin vận chuyển </button>
          <?php
          }
          ?>
          <a href="index.php?quanly=thongTinThanhToan" class="dathang_button">Thanh toán</a>
        </div>
      </form>
    </div>
  </div>
</div>
</div>