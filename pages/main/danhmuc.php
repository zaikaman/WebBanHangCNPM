<!-- Include Bootstrap CSS in your header -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<div class="main_content">
    <?php
        // Get the category title
        $sql_name = "SELECT * FROM tbl_danhmuc_baiviet WHERE tbl_danhmuc_baiviet.id_baiviet='$_GET[id_baiviet]' LIMIT 1";
        $query_name = mysqli_query($mysqli, $sql_name);
        $row_title = mysqli_fetch_array($query_name);

        // Pagination setup
        if (isset($_GET['trang'])) {
            $page = $_GET['trang'];
        } else {
            $page = '';
        }
        if ($page == '' || $page == 1) {
            $begin = 0;
        } else {
            $begin = ($page * 8) - 8;
        }
    ?>
    <h3 class="text-center text-uppercase my-4">Danh Mục Bài viết: <span><?php echo $row_title['tendanhmuc_baiviet'] ?></span></h3>

    <div class="container mt-3">
        <div class="row">
            <?php
            // Query to select posts in the specified category with pagination
            $sql_bv = "SELECT * FROM tbl_baiviet WHERE id_danhmuc = '$_GET[id_baiviet]' ORDER BY id DESC LIMIT $begin,8";
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
                                <!-- <p class="card-text"><?php echo $row['tomtat'] ?></p> -->
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

    <div style="clear:both;"></div>
    <?php
    // Calculate total pages
    $sql_page = mysqli_query($mysqli, "SELECT * FROM tbl_baiviet WHERE id_danhmuc = '$_GET[id_baiviet]'");
    $row_count = mysqli_num_rows($sql_page);
    $trang = ceil($row_count / 8);
    ?>
    <ul style="display: flex; flex-direction: row; width: 100%; justify-content: center">
        <?php
        for ($i = 1; $i <= $trang; $i++) {
        ?>
            <div class="phantrang">
                <div <?php if ($i == $page) {
                            echo 'style="background: #FFFFFF;"';
                        } else {
                            echo '';
                        } ?>>
                    <a href="index.php?quanly=danhmucbaiviet&id_baiviet=<?php echo $_GET['id_baiviet'] ?>&trang=<?php echo $i ?>"><?php echo $i ?></a>
                </div>
            </div>
        <?php
        }
        ?>
    </ul>
</div>

<!-- Include Bootstrap JS and dependencies in your footer -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
