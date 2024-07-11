<?php include ('partials/menu.php') ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>
        <br />
        <br />

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'] . '<br/><br/><br/>';
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'] . '<br/><br/><br/>';
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'] . '<br/><br/><br/>';
            unset($_SESSION['update']);
        }
        if (isset($_SESSION['remove'])) {
            echo $_SESSION['remove'] . '<br/><br/><br/>';
            unset($_SESSION['remove']);
        }
        ?>

        <!-- Button to Add Admin -->
        <a href="add-food.php" class="btn-primary">Add Food</a>
        <br />
        <br />
        <br />

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image Name</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Action</th>
            </tr>

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
                        $category_id = $rows['category_id'];
                        $featured = $rows['featured'];
                        $active = $rows['active'];

                        ?>
                        <tr>
                            <td><?php echo $sn++; ?>.</td>
                            <td><?php echo $title; ?></td>
                            <td><?php echo $price; ?></td>                            
                            <td>
                                <?php 
                                    if ($image_name != '') {
                                        ?><img src="<?php echo SITEURL?>/images/food/<?php echo $image_name; ?>" width="100px"/>
                                    <?php    
                                    } else {
                                        echo "<div class='error'>Image Not Added</div>";
                                    }
                                ?>
                            </td>
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td><div class='error' colspan='7'>Food Not Added Yet. </td> </tr>";
                }
            }
            ?>
        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include ('partials/footer.php') ?>