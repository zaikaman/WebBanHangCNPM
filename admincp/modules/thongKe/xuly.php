<?php
include('..//..//config/config.php');

if(isset($_POST['thongke'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    
    $sql_thongke = "SELECT * FROM tbl_cart 
                    WHERE ngaydathang BETWEEN ? AND ?
                    ORDER BY ngaydathang DESC";
                    
    $stmt = mysqli_prepare($mysqli, $sql_thongke);
    mysqli_stmt_bind_param($stmt, "ss", $start_date, $end_date);
    mysqli_stmt_execute($stmt);
    $query_thongke = mysqli_stmt_get_result($stmt);
    
    // Store result in session for display
    $_SESSION['thongke_result'] = array();
    while($row = mysqli_fetch_array($query_thongke)) {
        $_SESSION['thongke_result'][] = $row;
    }
    
    header("Location: ../../index.php?action=thongKe&query=lietke");
}
?> 