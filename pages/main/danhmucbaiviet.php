<div class="main_content">
    <?php
        $sql_bv= "SELECT * FROM tbl_baiviet WHERE tbl_baiviet.id='$_GET[id_baiviet]' ORDER BY id DESC";
        $query_bv= mysqli_query($mysqli,$sql_bv);
        $sql_name= "SELECT * FROM tbl_danhmuc_baiviet WHERE tbl_danhmuc_baiviet.id_baiviet='$_GET[id_baiviet]' LIMIT 1";
        $query_name= mysqli_query($mysqli,$sql_name);
        $row_title= mysqli_fetch_array($query_name);
    ?>
    <h3>Danh Mục Bài viết: <span style="text-align: center; text-transform: uppercase"> <?php echo $row_title['tendanhmuc_baiviet']?> </span>  </h3>



	<div class="container mt-3">
            <div class="row">
                <?php
                while ($row = mysqli_fetch_array($query_name)) {
                ?>
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                        <div class="product card h-100">
                            <a href="index.php?quanly=baiviet&id=<?php echo $row['id']?>"  class="text-decoration-none text-dark">
                                <img src="admincp/modules/quanLyBaiViet/uploads/<?php echo $row['hinhanh'] ?>" class="card-img-top img-fluid">
                                <div class="card-body text-center">
								<p class="product_name"><?php echo $row['tenbaiviet'] ?></p>
								<p class="product_name"><?php echo $row['tomtat'] ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
</div>