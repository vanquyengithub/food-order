<?php include ('partials_front/menu.php'); ?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <form action="food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        // Query to Get all Admin
        $sql = "SELECT * FROM tbl_food";
        // Execute the Query
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if ($res == TRUE) {
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                $sn = 1;
                while ($rows = mysqli_fetch_assoc($res)) {
                    $id = $rows['id'];
                    $title = $rows['title'];
                    $price = $rows['price'];
                    $image_name = $rows['image_name'];
                    $description = $rows['description'];

                    ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                            if ($image_name != '') {
                                ?>
                                <img src="<?php echo SITEURL ?>/images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>"
                                    class="img-responsive img-curve" />
                                <?php
                            } else {
                                echo "<div class='img-responsive img-curve'>Image Not Added</div>";
                            }
                            ?>
                        </div>
                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price">$<?php echo $price; ?></p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href="order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo "<div colspan='7'>Food Not Added Yet. </div>";
            }
        }
        ?>



        <div class="clearfix"></div>



    </div>

</section>
<!-- fOOD Menu Section Ends Here -->

<?php include ('partials_front/footer.php'); ?>