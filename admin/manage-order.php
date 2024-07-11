<?php include ('partials/menu.php') ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>
        <br />
        <br />

        <?php
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'].'<br/><br/><br/>';
            unset($_SESSION['update']);
        }
        ?>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Action</th>
            </tr>

            <?php
            // Query to Get all Admin
            $sql = "SELECT * FROM tbl_order";
            // Execute the Query
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            if ($res == TRUE) {
                $count = mysqli_num_rows($res);

                if ($count > 0) {
                    $sn = 1;
                    while ($rows = mysqli_fetch_assoc($res)) {
                        $id = $rows['id'];
                        $food = $rows['food'];
                        $price = $rows['price'];
                        $qty = $rows['qty'];
                        $total = $rows['total'];
                        $order_date = $rows['order_date'];
                        $status = $rows['status'];
                        $customer_name = $rows['customer_name'];
                        $customer_contact = $rows['customer_contact'];
                        $customer_email = $rows['customer_email'];
                        $customer_address = $rows['customer_address'];

                        ?>
                        <tr>
                            <td><?php echo $sn++; ?>.</td>
                            <td><?php echo $food; ?></td>
                            <td><?php echo $price; ?></td>
                            <td><?php echo $qty; ?></td>
                            <td><?php echo $total; ?></td>
                            <td><?php echo $order_date; ?></td>
                            <?php if ($status == 'Ordered') { ?>
                                <td style="color: blue;"><?php echo $status; ?></td>
                            <?php } else if ($status == 'On Delivery') { ?>
                                <td style="color: orange;"><?php echo $status; ?></td>
                            <?php } else if ($status == 'Delivered') { ?>
                                <td style="color: green;"><?php echo $status; ?></td>
                            <?php } else if ($status == 'Cancelled') { ?>
                                <td style="color: red;"><?php echo $status; ?></td>
                            <?php } ?>
                            <td><?php echo $customer_name; ?></td>
                            <td><?php echo $customer_contact; ?></td>
                            <td><?php echo $customer_email; ?></td>
                            <td><?php echo $customer_address; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<div class='error' colspan='7'>Order Not Added Yet. </td> </tr>";
                }
            }
            ?>
        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include ('partials/footer.php') ?>