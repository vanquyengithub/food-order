<?php include ('partials_front/menu.php'); ?>

<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
        // Query to Get all Admin
        $sql = "SELECT * FROM tbl_category";
        // Execute the Query
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if ($res == TRUE) {
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                $sn = 1;
                while ($rows = mysqli_fetch_assoc($res)) {
                    $id = $rows['id'];
                    $title = $rows['title'];
                    $image_name = $rows['image_name'];

                    ?>
                    <a href="category-foods.php?id=<?php echo $id; ?>&title=<?php echo $title; ?>">
                        <div class="box-3 float-container">
                            <?php
                            if ($image_name != '') {
                                ?>
                                <img src="<?php echo SITEURL ?>/images/category/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve" />
                                <?php
                            } else {
                                echo "<div class='img-responsive img-curve' >Image Not Added</div>";
                            }
                            ?>

                            <h3 class="float-text text-white"><?php echo $title; ?></h3>
                        </div>
                    </a>
                    <?php
                }
            } else {
                echo "<div class='error' colspan='7'>Category Not Added Yet. </div>";
            }
        }
        ?>



        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->


<?php include ('partials_front/footer.php'); ?>