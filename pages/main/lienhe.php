<div class="main_content">
    <h2><strong>Liên hệ</strong></h2>
    <?php
    $sql_lh = "SELECT * FROM tbl_lienhe WHERE id=1";
    $query_lh = mysqli_query($mysqli, $sql_lh);

    while ($row = mysqli_fetch_array($query_lh)) {
        echo htmlspecialchars_decode($row['thongtinlienhe']);
    }
    ?>
</div>
