<?php include ('partials/menu.php') ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br />
        <br />

        <?php
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_admin WHERE id = $id";
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if ($res==TRUE) {
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);

                $full_name = $row['full_name'];
                $username = $row['username'];
            } else {
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'].'<br/><br/><br/>';
            unset($_SESSION['update']);
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" value="<?php echo $full_name?>"></td>
                </tr>

                <tr>
                    <td>UserName: </td>
                    <td><input type="text" name="username" value="<?php echo $username?>"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
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
    $newFullName = $_POST['full_name'] != '' ? $_POST['full_name'] : $full_name;
    $newUsername = $_POST['username'] != '' ? $_POST['username'] : $username;

    //2. SQL Query to Save the data in database
    $sql = "UPDATE tbl_admin SET
            full_name='$newFullName', 
            username='$newUsername'
            WHERE id='$id'";

    //3. Execute Query and Save Data in database
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    //4 Check whether the (Query is Executed) data is inserted or not and display appropriate message
    if ($res == TRUE) {
        // Data Inserted
        // echo "Data Inserted";
        $_SESSION['update'] = "<div class='success'>Admin Updated Successfully</div>";
        // Redirect Page to Manage Admin
        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {
        // echo "Insert Failed";
        $_SESSION['update'] = "<div class='error'>Failed to Update Admin</div>";
        header("location:" . SITEURL . 'admin/update-admin.php');
    }
}

?>