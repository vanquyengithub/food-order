<?php include ('partials/menu.php') ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Update Password</h1>
        <br />
        <br />

        <?php
        if (isset($_SESSION['change-password'])) {
            echo $_SESSION['change-password'] . '<br/><br/><br/>';
            unset($_SESSION['change-password']);
        }
        $id = $_GET['id'];
        ?>
        
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Old Password: </td>
                    <td><input type="password" name="old_password" placeholder="Input Old Password"></td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td><input type="password" name="new_password" placeholder="Input New Password"></td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td><input type="password" name="confirm_password" placeholder="Input Confirm Password"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include ('partials/footer.php') ?>

<?php
// Process the Value from Form and Save it in Database
// Check whether the submit button is clicked or not
if (isset($_POST['submit'])) {
    //1. Get Data form Form
    $id = $_POST['id'];
    $oldPassword = md5($_POST['old_password']);
    $newPassword = md5($_POST['new_password']);
    $confirmPassword = md5($_POST['confirm_password']);

    //2. SQL Query to Save the data in database
    $sql = "SELECT id FROM tbl_admin WHERE id='$id' AND password='$oldPassword'";

    //3. Execute Query and Save Data in database
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    //4. Check whether the (Query is Executed) data is inserted or not and display appropriate message
    if ($res == TRUE) {
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            $row = mysqli_fetch_assoc($res);

            $id = $row['id'];

            if ($newPassword == $confirmPassword) {
                $sql2 = "UPDATE tbl_admin SET password='$newPassword' WHERE id='$id'";
                $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
                if ($res2 == TRUE) {
                    $_SESSION['change-password'] = "<div class='success'>Password Updated Successfully</div>";
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                } else {
                    $_SESSION['change-password'] = "<div class='error'>Failed to Update Password</div>";
                    header('location:' . SITEURL . 'admin/update-password.php');
                }
            } else {
                $_SESSION['pwd-not-match'] = "<div class='error'>Password Not Match</div>";
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
        } else {
            $_SESSION['user-not-found'] = "<div class='error'>User Not Found</div>";
            header('location:' . SITEURL . 'admin/manage-admin.php');
        }
    }
}

?>