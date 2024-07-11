<?php 
    if (!isset($_SESSION['loginUser'])) {
        $_SESSION['loginFail'] = "<div class='error'>Please login first</div>";
        header('location:' . SITEURL . 'admin/login.php');
    }
?>