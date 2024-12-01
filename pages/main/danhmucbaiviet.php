<!-- Include Bootstrap CSS in your header -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<div class="main_content">
    <?php
        // Get the category title
        $sql_name = "SELECT * FROM tbl_danhmuc_baiviet WHERE tbl_danhmuc_baiviet.id_baiviet='$_GET[id_baiviet]' LIMIT 1";
        $query_name = mysqli_query($mysqli, $sql_name);
        $row_title = mysqli_fetch_array($query_name);
    ?>
    <h3 class="text-center text-uppercase my-4">Danh Mục Bài viết: <span><?php echo $row_title['tendanhmuc_baiviet'] ?></span></h3>

    <div class="container mt-3">
        <div class="row">
            <?php
            // Query to select posts in the specified category
            $sql_bv = "SELECT * FROM tbl_baiviet WHERE id_danhmuc = '$_GET[id_baiviet]' ORDER BY id DESC";
            $query_bv = mysqli_query($mysqli, $sql_bv);

            // Check if there are any posts
            if(mysqli_num_rows($query_bv) > 0) {
                while ($row = mysqli_fetch_array($query_bv)) {
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <a href="<?php echo $row['link'] ?>" class="text-decoration-none text-dark">
                                <img src="admincp/modules/quanLyBaiViet/uploads/<?php echo $row['hinhanh'] ?>" class="card-img-top img-fluid" alt="<?php echo $row['tenbaiviet'] ?>">
                            </a>
                            <div class="card-body text-center">
                                <h5 class="card-title">
                                    <a href="<?php echo $row['link'] ?>" class="text-dark"><?php echo $row['tenbaiviet'] ?></a>
                                </h5>

                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                // Display message when no posts are found
                ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info" role="alert">
                        Hiện chưa có bài viết nào trong danh mục này.
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and dependencies in your footer -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
