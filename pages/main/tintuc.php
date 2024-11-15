<!-- Include Bootstrap CSS in your header -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<div class="main_content">
    <div class="container my-5">
        <h3 class="text-center text-uppercase mb-4">Tin tức mới nhất</h3>
        <div class="row">
            <?php
            // Fetch 10 latest news in ascending order by id
            $sql_tintuc = "SELECT * FROM tbl_baiviet ORDER BY id ASC LIMIT 10";
            $query_tintuc = mysqli_query($mysqli, $sql_tintuc);
    
            while($row_tintuc = mysqli_fetch_array($query_tintuc)) {
            ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <a href="<?php echo $row_tintuc['link']; ?>">
                        <img src="admincp/modules/quanLyBaiViet/uploads/<?php echo $row_tintuc['hinhanh']; ?>" class="card-img-top" alt="<?php echo $row_tintuc['tenbaiviet']; ?>">
                    </a>
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <a href="<?php echo $row_tintuc['link']; ?>" class="text-dark">
                                <?php echo $row_tintuc['tenbaiviet']; ?>
                            </a>
                        </h5>
                    </div>
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
