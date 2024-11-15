<?php
$sql_pro_info = "SELECT * FROM tbl_sanpham WHERE tbl_sanpham.id_sp = '$_GET[id]' LIMIT 1";
$pro_info = mysqli_query($mysqli, $sql_pro_info);
?>
<div class="main_content">
    <?php
    while ($info = mysqli_fetch_array($pro_info)) {
    ?>
        <form class="product_content" method="POST" action="/pages/main/themgiohang.php?idsanpham=<?php echo $info['id_sp'] ?>" data-ajax="true">
            <div class="product_img">
                <img class="img" src="admincp/modules/quanLySanPham/uploads/<?php echo $info['hinh_anh'] ?>" alt="">
            </div>
            <div class="product_detail">
                <div>
                    <p class="ten_sp"><?php echo $info['ten_sp'] ?></p>
                    <?php
                    if ($info['so_luong_con_lai'] > 0) {
                    ?>
                        <p class="quantity">Tình trạng : <span style="color : red; font-weight : 500;">Còn hàng</span></p>
                    <?php } else { ?>
                        <p class="quantity">Tình trạng : <span style="color : red; font-weight : 500;">Hết hàng</span></p>
                    <?php } ?>
                    <p class="gia_sp"><?php echo number_format($info['gia_sp'], 0, ',', ',') . 'đ' ?></p>
                    <p>Danh mục : </p>
                </div>
                <div class="soluong">
                    <label for="" style="color : #55595C; font-size : 16px;">Số lượng :</label>
                    <div style="display : block">
                        <button id="giam" class="soluong_btn">
                            -
                        </button>
                        <input class="soluong_input" id="soluong_input" name="so_luong" type="number" value="1" min="1" max="<?php echo $info['so_luong_con_lai']; ?>">
                        <button id="tang" class="soluong_btn">
                            +
                        </button>
                    </div>
                </div>
                <div class="tabs">
                    <ul id="tabs-nav">
                        <li><a href="#chitiet">Tóm tắt </a></li>
                        <li><a href="#noidung">Nội dung</a></li>
                    </ul>
                    <div id="tabs-content">
                        <div id="chitiet" class="tab-content">
                            <?php echo $info['tom_tat'] ?>
                        </div>
                        <div id="noidung" class="tab-content">
                            <?php echo $info['noi_dung'] ?>
                        </div>
                    </div>
                </div>
                <?php if (isset($_SESSION['id_khachhang']) && isset($_SESSION['dang_ky'])) { ?>
                    <div style="width : 100%; display : flex; align-items : center; justify-content : center">
                        <input class="mua_btn" type="submit" name="themgiohang" value="Thêm vào giỏ hàng">
                    </div>
                <?php } else { ?>
                    <div style="width : 100%; display : flex; align-items : center; justify-content : center">
                        <a style="align-items: center; color : white ;" class="mua_btn" href="index.php?quanly=dangnhap">Đăng nhập để mua hàng</a>
                    </div>
                <?php } ?>
            </div>

        </form>

    <?php } ?>
</div>
<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById("soluong_input");
        const btnDecrease = document.getElementById("giam");
        const btnIncrease = document.getElementById("tang");
        const maxQuantity = parseInt(input.max);

        btnIncrease.addEventListener("click", function() {
            let currentQuantity = parseInt(input.value);
            if (currentQuantity < maxQuantity) {
                input.value = currentQuantity + 1;
            }
        });

        btnDecrease.addEventListener("click", function() {
            let currentQuantity = parseInt(input.value);
            if (currentQuantity > 1) {
                input.value = currentQuantity - 1;
            }
        });

        // input.addEventListener("input", function() {
        //     if (input.value > maxQuantity) {
        //         input.value = maxQuantity;
        //     } else if (input.value < 1) {
        //         input.value = 1;
        //     }
        // });
    });
</script> -->

