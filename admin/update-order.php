<?php include ('partials/menu.php') ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br />
        <br />

        <?php
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_order WHERE id = $id";
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if ($res == TRUE) {
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);

                $food = $row['food'];
                $price = $row['price'];
                $qty = $row['qty'];
                $status = $row['status'];
                $customer_name = $row['customer_name'];
                $customer_contact = $row['customer_contact'];
                $customer_email = $row['customer_email'];
                $customer_address = $row['customer_address'];
            } else {
                header('location:' . SITEURL . 'admin/manage-order.php');
            }
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'] . '<br/><br/><br/>';
            unset($_SESSION['update']);
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Food: </td>
                    <td><b><?php echo $food; ?></b></td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td><b>$<?php echo $price; ?></b></td>
                </tr>

                <tr>
                    <td>Qty: </td>
                    <td><input type="number" name="qty" value="<?php echo $qty; ?>"></td>
                </tr>

                <tr>
                    <td>Status: </td>
                    <td>
                        <select name="status">
                            <option value="Ordered" <?php if ($status == "Ordered") {echo "selected";} ?>>Ordered</option>
                            <option value="On Delivery" <?php if ($status == "On Delivery") {echo "selected";} ?>>On Delivery</option>
                            <option value="Delivered" <?php if ($status == "Delivered") {echo "selected";} ?>>Delivered</option>
                            <option value="Cancelled" <?php if ($status == "Cancelled") {echo "selected";} ?>>Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Customer Name: </td>
                    <td><input type="text" name="customer_name" value="<?php echo $customer_name; ?>"></td>
                </tr>

                <tr>
                    <td>Customer Contact: </td>
                    <td><input type="tel" name="customer_contact" value="<?php echo $customer_contact; ?>"></td>
                </tr>

                <tr>
                    <td>Customer Email: </td>
                    <td><input type="email" name="customer_email" value="<?php echo $customer_email; ?>"></td>
                </tr>

                <tr>
                    <td>Customer Address: </td>
                    <td><textarea cols="30" rows="5" name="customer_address"><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
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
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $total = $price * $qty;
    $status = $_POST['status'];
    $customer_name = $_POST['customer_name'];
    $customer_contact = $_POST['customer_contact'];
    $customer_email = $_POST['customer_email'];
    $customer_address = $_POST['customer_address'];

    //2. SQL Query to Save the data in database
    $sql2 = "UPDATE tbl_order SET
            qty='$qty', 
            total='$total',
            status='$status',
            customer_name='$customer_name',
            customer_contact='$customer_contact',
            customer_email='$customer_email',
            customer_address='$customer_address'
            WHERE id='$id'";

    //3. Execute Query and Save Data in database
    $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

    //4 Check whether the (Query is Executed) data is inserted or not and display appropriate message
    if ($res2 == TRUE) {
        // Data Inserted
        // echo "Data Inserted";
        $_SESSION['update'] = "<div class='success'>Order Updated Successfully</div>";
        // Redirect Page to Manage Admin
        header("location:" . SITEURL . 'admin/manage-order.php');
    } else {
        // echo "Insert Failed";
        $_SESSION['update'] = "<div class='error'>Failed to Update Order</div>";
        header("location:" . SITEURL . 'admin/update-order.php');
    }
}

?>