<div class="main_content">
    <p><strong>Liên hệ</strong> </p>
    <?php
    $sql_lh = "SELECT * FROM tbl_lienhe WHERE id=1";
    $query_lh = mysqli_query($mysqli, $sql_lh);
    ?>
    <?php
    while ($row = mysqli_fetch_array($query_lh)) {
    ?>
        <p> <?php echo $row['thongtinlienhe'] ?> </p>
    <?php
    }
    ?>
</div>
