<?php include ('partials/menu.php') ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br />
        <br />

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'].'<br/><br/><br/>';
            unset($_SESSION['add']);
        } 
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'].'<br/><br/><br/>';
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'].'<br/><br/><br/>';
            unset($_SESSION['update']);
        }
        if (isset($_SESSION['change-password'])) {
            echo $_SESSION['change-password'].'<br/><br/><br/>';
            unset($_SESSION['change-password']);
        }
        if (isset($_SESSION['user-not-found'])) {
            echo $_SESSION['user-not-found'].'<br/><br/><br/>';
            unset($_SESSION['user-not-found']);
        }
        if (isset($_SESSION['pwd-not-match'])) {
            echo $_SESSION['pwd-not-match'].'<br/><br/><br/>';
            unset($_SESSION['pwd-not-match']);
        }
        ?>


        <!-- Button to Add Admin -->
        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br />
        <br />
        <br />

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Full Name</th>
                <th>UserName</th>
                <th>Action</th>
            </tr>

            <?php
            // Query to Get all Admin
            $sql = "SELECT * FROM tbl_admin";
            // Execute the Query
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            if ($res == TRUE) {
                $count = mysqli_num_rows($res);

                if ($count > 0) {
                    $sn = 1;
                    while ($rows = mysqli_fetch_assoc($res)) {
                        $id = $rows['id'];
                        $full_name = $rows['full_name'];
                        $username = $rows['username'];

                        ?>
                        <tr>
                            <td><?php echo $sn++; ?>.</td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Update Password</a>
                                <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<div class='error' colspan='7'>Admin Not Added Yet. </td> </tr>";
                }
            }
            ?>
        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include ('partials/footer.php') ?>