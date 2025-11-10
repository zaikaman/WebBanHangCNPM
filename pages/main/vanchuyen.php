<?php
// Thông tin về thay đổi logic: Việc lưu vận chuyển giờ được thực hiện ở trang thanh toán
// Trang này chỉ dùng để người dùng nhập và xem thông tin vận chuyển trước khi thanh toán

// Kiểm tra user đã đăng nhập chưa
if (!isset($_SESSION['id_khachhang']) || empty($_SESSION['id_khachhang'])) {
    echo '<script>alert("Vui lòng đăng nhập để tiếp tục!"); window.location.href="index.php?quanly=dangnhap";</script>';
    exit();
}

// Kiểm tra database connection
if (!isset($mysqli) || !$mysqli) {
    echo '<div class="alert alert-danger">Lỗi kết nối cơ sở dữ liệu. Vui lòng thử lại sau.</div>';
    exit();
}

// XỬ LÝ LƯU THÔNG TIN VẬN CHUYỂN
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $id_dangky = mysqli_real_escape_string($mysqli, $_SESSION['id_khachhang']);
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
    $dia_chi_chi_tiet = mysqli_real_escape_string($mysqli, $_POST['dia_chi_chi_tiet']);
    $quan_huyen = mysqli_real_escape_string($mysqli, $_POST['quan_huyen']);
    $tinh_thanh = mysqli_real_escape_string($mysqli, $_POST['tinh_thanh']);
    $note = mysqli_real_escape_string($mysqli, $_POST['note'] ?? '');
    
    // Kiểm tra xem đã có thông tin vận chuyển chưa
    $sql_check = mysqli_query($mysqli, "SELECT * FROM tbl_giaohang WHERE id_dangky='$id_dangky' LIMIT 1");
    
    if (mysqli_num_rows($sql_check) > 0) {
        // Update thông tin cũ
        $sql_update = "UPDATE tbl_giaohang SET name='$name', phone='$phone', dia_chi_chi_tiet='$dia_chi_chi_tiet', quan_huyen='$quan_huyen', tinh_thanh='$tinh_thanh', note='$note' WHERE id_dangky='$id_dangky'";
        mysqli_query($mysqli, $sql_update);
    } else {
        // Insert thông tin mới
        $sql_insert = "INSERT INTO tbl_giaohang (name, phone, dia_chi_chi_tiet, quan_huyen, tinh_thanh, note, id_dangky) VALUES ('$name', '$phone', '$dia_chi_chi_tiet', '$quan_huyen', '$tinh_thanh', '$note', '$id_dangky')";
        mysqli_query($mysqli, $sql_insert);
    }
    
    // Redirect sang trang thanh toán
    echo '<script>window.location.href="index.php?quanly=thongTinThanhToan";</script>';
    exit();
}

$name = '';
$phone = '';
$dia_chi_chi_tiet = '';
$quan_huyen = '';
$tinh_thanh = '';
$note = '';

$id_dangky = mysqli_real_escape_string($mysqli, $_SESSION['id_khachhang']);
$sql_get_vanchuyen = mysqli_query($mysqli, "SELECT * FROM tbl_giaohang WHERE id_dangky='$id_dangky' LIMIT 1");

if ($sql_get_vanchuyen) {
    $count = mysqli_num_rows($sql_get_vanchuyen);
    if ($count > 0) {
        $row_get_vanchuyen = mysqli_fetch_array($sql_get_vanchuyen);
        $name = htmlspecialchars($row_get_vanchuyen['name'] ?? '', ENT_QUOTES, 'UTF-8');
        $phone = htmlspecialchars($row_get_vanchuyen['phone'] ?? '', ENT_QUOTES, 'UTF-8');
        $dia_chi_chi_tiet = htmlspecialchars($row_get_vanchuyen['dia_chi_chi_tiet'] ?? '', ENT_QUOTES, 'UTF-8');
        $quan_huyen = htmlspecialchars($row_get_vanchuyen['quan_huyen'] ?? '', ENT_QUOTES, 'UTF-8');
        $tinh_thanh = htmlspecialchars($row_get_vanchuyen['tinh_thanh'] ?? '', ENT_QUOTES, 'UTF-8');
        $note = htmlspecialchars($row_get_vanchuyen['note'] ?? '', ENT_QUOTES, 'UTF-8');
    }
}
?>
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
    <div class="row vanchuyen-form">
      <form id="shippingForm" action="index.php?quanly=vanChuyen" autocomplete="off" method="POST" class="login_content" style="margin-top : 20px; width : 100%">
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
            <label for="dia_chi_chi_tiet">Địa chỉ chi tiết:</label>
            <input type="text" id="dia_chi_chi_tiet" name="dia_chi_chi_tiet" class="form-control" value="<?php echo $dia_chi_chi_tiet ?>" placeholder="Số nhà, tên đường...">
          </div>
          <span id="addressError" style="color: red;"></span>
        </div>
        <div class="form-group">
          <div style="width : 100%; display : flex; flex-direction : row;  justify-content: center;
  align-items: center;">
            <label for="tinh_thanh">Tỉnh/Thành phố:</label>
            <select id="tinh_thanh" name="tinh_thanh" class="form-control">
              <option value="">-- Chọn Tỉnh/Thành phố --</option>
            </select>
          </div>
          <span id="provinceError" style="color: red;"></span>
        </div>
        <div class="form-group">
          <div style="width : 100%; display : flex; flex-direction : row;  justify-content: center;
  align-items: center;">
            <label for="quan_huyen">Quận/Huyện:</label>
            <select id="quan_huyen" name="quan_huyen" class="form-control" disabled>
              <option value="">-- Chọn Quận/Huyện --</option>
            </select>
          </div>
          <span id="districtError" style="color: red;"></span>
        </div>
        <div class="form-group">
          <div style="width : 100%; display : flex; flex-direction : row;  justify-content: center;
  align-items: center;">
            <label for="note">Ghi chú:</label>
            <input type="text" name="note" class="form-control" value="<?php echo $note ?>" placeholder="....">
          </div>
        </div>
        <div style="display: flex; flex-direction: row; align-items: center; width: auto; gap : 20px">
          <button type="submit" id="checkoutButton" class="dathang_button">Tiếp tục thanh toán</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Load dữ liệu địa chỉ Việt Nam -->
<script src="js/vietnam_address_data.js"></script>

<script>
  // Khởi tạo dữ liệu địa chỉ đã lưu
  const savedTinhThanh = '<?php echo $tinh_thanh ?>';
  const savedQuanHuyen = '<?php echo $quan_huyen ?>';
  
  // Load danh sách tỉnh/thành phố
  document.addEventListener('DOMContentLoaded', function() {
    const tinhThanhSelect = document.getElementById('tinh_thanh');
    const quanHuyenSelect = document.getElementById('quan_huyen');
    
    // Populate tỉnh/thành phố
    vietnamAddressData.provinces.forEach(function(province) {
      const option = document.createElement('option');
      option.value = province.name;
      option.textContent = province.name;
      option.dataset.id = province.id;
      
      // Chọn tỉnh đã lưu
      if (province.name === savedTinhThanh) {
        option.selected = true;
      }
      
      tinhThanhSelect.appendChild(option);
    });
    
    // Xử lý khi chọn tỉnh/thành phố
    tinhThanhSelect.addEventListener('change', function() {
      const selectedOption = this.options[this.selectedIndex];
      const provinceId = selectedOption.dataset.id;
      
      // Reset quận/huyện
      quanHuyenSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
      quanHuyenSelect.disabled = false;
      
      if (provinceId) {
        // Load danh sách quận/huyện
        const districts = getDistrictsByProvince(provinceId);
        districts.forEach(function(district) {
          const option = document.createElement('option');
          option.value = district.name;
          option.textContent = district.name;
          
          // Chọn quận đã lưu (chỉ khi tỉnh được chọn khớp với tỉnh đã lưu)
          if (savedTinhThanh === selectedOption.value && district.name === savedQuanHuyen) {
            option.selected = true;
          }
          
          quanHuyenSelect.appendChild(option);
        });
      } else {
        quanHuyenSelect.disabled = true;
      }
    });
    
    // Trigger change event để load quận/huyện nếu đã có tỉnh được chọn
    if (savedTinhThanh) {
      tinhThanhSelect.dispatchEvent(new Event('change'));
    }
  });

  // Hàm kiểm tra tính hợp lệ của form
  function validateForm() {
    let valid = true;
    let name = document.getElementById('name').value.trim();
    let phone = document.getElementById('phone').value.trim();
    let dia_chi_chi_tiet = document.getElementById('dia_chi_chi_tiet').value.trim();
    let quan_huyen = document.getElementById('quan_huyen').value.trim();
    let tinh_thanh = document.getElementById('tinh_thanh').value.trim();
    
    // Xóa các thông báo lỗi trước đó
    document.getElementById('nameError').innerText = '';
    document.getElementById('phoneError').innerText = '';
    document.getElementById('addressError').innerText = '';
    document.getElementById('districtError').innerText = '';
    document.getElementById('provinceError').innerText = '';
    
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
    if (dia_chi_chi_tiet === '') {
      document.getElementById('addressError').innerText = 'Vui lòng nhập địa chỉ chi tiết.';
      valid = false;
    }
    if (tinh_thanh === '') {
      document.getElementById('provinceError').innerText = 'Vui lòng chọn Tỉnh/Thành phố.';
      valid = false;
    }
    if (quan_huyen === '') {
      document.getElementById('districtError').innerText = 'Vui lòng chọn Quận/Huyện.';
      valid = false;
    }
    return valid;
  }

  // Kiểm tra khi submit form
  document.getElementById('shippingForm').addEventListener('submit', function(e) {
    if (!validateForm()) {
      e.preventDefault();
    }
  });
</script>
