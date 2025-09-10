<?php 
if(isset($_GET['dangXuat']) && $_GET['dangXuat'] == 1){
    unset($_SESSION['dangNhap']);
    header('Location:login.php');
}
?>

<!-- Include Pagination CSS and JS -->
<link href="css/pagination.css" rel="stylesheet">
<link href="css/bootstrap-override.css" rel="stylesheet">
<script src="js/pagination.js"></script>

<p class="text-end">
    <a href="index.php?dangXuat=1" class="btn btn-danger">
        Đăng xuất: 
        <?php if($_SESSION['dangNhap']) {
            echo $_SESSION['dangNhap'];    
        } ?>        
    </a>
</p>
