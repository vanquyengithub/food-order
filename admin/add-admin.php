<?php include ('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br />
        <br />

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'].'<br/><br/><br/>';
            unset($_SESSION['add']);
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>
                </tr>

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
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include ('partials/footer.php') ?>

<?php
// Process the Value from Form and Save it in Database
// Check whether the submit button is clicked or not
if (isset($_POST['submit'])) {
    //1. Get Data form Form
    $fullName = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); //Password Encrytion with MD5

    //2. SQL Query to Save the data in database
    $sql = "INSERT INTO tbl_admin SET
            full_name='$fullName', 
            username='$username',
            password='$password'";

    //3. Execute Query and Save Data in database
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    //4 Check whether the (Query is Executed) data is inserted or not and display appropriate message
    if ($res == TRUE) {
        // Data Inserted
        // echo "Data Inserted";
        $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>";
        // Redirect Page to Manage Admin
        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {
        // echo "Insert Failed";
        $_SESSION['add'] = "<div class='error'>Failed to Add Admin</div>";
        header("location:" . SITEURL . 'admin/add-admin.php');
    }
}

?>