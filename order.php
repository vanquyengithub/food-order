<?php include ('partials_front/menu.php'); ?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">

        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <?php
        if (isset($_GET['food_id'])) {
            $food_id = $_GET['food_id'];
        } else {
            header('location:' . SITEURL . 'index.php');
        }

        $sql = "SELECT * FROM tbl_food WHERE id = '$food_id'";
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if ($res == TRUE) {
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $image_name = $row['image_name'];
                $price = $row['price'];
            }
        }

        if (isset($_SESSION['order'])) {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
        ?>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <?php
                    if ($image_name != '') {
                        ?>
                        <img src="<?php echo SITEURL ?>/images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve"/>
                    <?php
                    } else {
                        echo "<div class='img-responsive img-curve'>Image Not Added</div>";
                    }
                    ?>
                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $title; ?></h3>
                    <input type="hidden" name="food" value="<?php echo $title; ?>">
                    <p class="food-price">$<?php echo $price; ?></p>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">
                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>

                </div>

            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive"
                    required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php include ('partials_front/footer.php'); ?>

<?php
// Process the Value from Form and Save it in Database
// Check whether the submit button is clicked or not
if (isset($_POST['submit'])) {
    //1. Get Data form Form
    $food = $_POST['food'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];

    $total = $price * $qty;

    $order_date = date("Y-m-d h:i:s");

    $status = "Ordered"; // Ordered, On Delivery, Delivered, Cancelled

    $customer_name = $_POST['full-name'];
    $customer_contact = $_POST['contact'];
    $customer_email = $_POST['email'];
    $customer_address = $_POST['address'];


    //2. SQL Query to Save the data in database
    $sql2 = "INSERT INTO `tbl_order`(`food`, `price`, `qty`, `total`, `order_date`, `status`, `customer_name`, `customer_contact`, `customer_email`, `customer_address`)
        VALUES ('$food','$price','$qty','$total', '$order_date', '$status','$customer_name','$customer_contact','$customer_email','$customer_address')";;

    //3. Execute Query and Save Data in database
    $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

    //4 Check whether the (Query is Executed) data is inserted or not and display appropriate message
    if ($res2 == TRUE) {
        // Data Inserted
        // echo "Data Inserted";
        $_SESSION['order'] = "<div class='success text-center'>Oreder Successfully</div>";
        // Redirect Page to Manage Admin
        header("location:" . SITEURL . 'index.php');
    } else {
        // echo "Insert Failed";
        $_SESSION['order'] = "<div class='error text-center'>Failed to Oreder</div>";
        header("location:" . SITEURL . 'index.php');
    }
}

?>