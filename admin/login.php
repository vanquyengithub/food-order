<?php include ('../configs/constants.php'); ?>

<html>

<head>
    <title>Food Order Website - Login Page</title>

    <link rel="stylesheet" href="../css/admin.css" />
</head>

<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <?php
            if (isset($_SESSION['loginFail'])) {
            echo $_SESSION['loginFail'].'<br/>';
            unset($_SESSION['loginFail']);
        } 
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>UserName: </td>
                    <td><input type="text" name="username" placeholder="Enter Your Username"></td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" placeholder="Enter Your Password"></td>
                </tr>

                <tr>
                    <td>
                        <input type="submit" name="submit" value="Login" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>

</body>

</html>

<?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    if ($res == TRUE) {
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            $row = mysqli_fetch_assoc($res);
            $_SESSION['loginUser'] = $row['username'];
            header('location:' . SITEURL . 'admin/');
        } else {
            $_SESSION['loginFail'] = "<div class='error'>Not Correct User</div>";
            header('location:' . SITEURL . 'admin/login.php');
        }
    }
}

?>