<?php 
if(isset($_GET['dangXuat']) && $_GET['dangXuat'] == 1){
    unset($_SESSION['dangNhap']);
    header('Location:login.php');
}
?>
<p class="text-end">
    <a href="index.php?dangXuat=1" class="btn btn-danger">
        Đăng xuất: 
        <?php if($_SESSION['dangNhap']) {
            echo $_SESSION['dangNhap'];    
        } ?>        
    </a>
</p>
