<?php include ('partials/menu.php') ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br />
        <br />

        <?php
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_food WHERE id = $id";
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if ($res == TRUE) {
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $description = $row['description'];
                $price = $row['price'];
                $image_name = $row['image_name'];
                $category_id = $row['category_id'];
                $featured = $row['featured'];
                $active = $row['active'];
            } else {
                header('location:' . SITEURL . 'admin/manage-food.php');
            }
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'] . '<br/><br/><br/>';
            unset($_SESSION['update']);
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'] . '<br/><br/><br/>';
            unset($_SESSION['upload']);
        }
        if (isset($_SESSION['remove'])) {
            echo $_SESSION['remove'] . '<br/><br/><br/>';
            unset($_SESSION['remove']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td><textarea cols="30" rows="5" name="description"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td><input type="number" name="price" value="<?php echo $price; ?>"></td>
                </tr>

                <tr>
                    <td>Current File Image: </td>
                    <td>
                        <?php
                        if ($image_name != '') {
                            ?><img src="<?php echo SITEURL ?>/images/food/<?php echo $image_name; ?>" width="100px" />
                            <?php
                        } else {
                            echo "<div class='error'>Image Not Added</div>";
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Choose New File Image: </td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php
                            $sql2 = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

                            if ($res2 == TRUE) {
                                $count = mysqli_num_rows($res2);

                                if ($count > 0) {
                                    while ($rows = mysqli_fetch_assoc($res2)) {
                                        $id_of_category = $rows['id'];
                                        $title = $rows['title'];
                                        ?>
                                        <option value="<?php echo $id_of_category; ?>" <?php if ($category_id == $id_of_category) {
                                               echo "selected";
                                           } ?>><?php echo $title; ?></option>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <option value="0">No Category Available</option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                            echo "checked";
                        } ?> type="radio" name="featured"
                            value="Yes">Yes

                        <input <?php if ($featured == "No") {
                            echo "checked";
                        } ?> type="radio" name="featured"
                            value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if ($active == "Yes") {
                            echo "checked";
                        } ?> type="radio" name="active"
                            value="Yes">Yes

                        <input <?php if ($active == "No") {
                            echo "checked";
                        } ?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="old_image" value="<?php echo $image_name; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
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
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $old_image_name = $_POST['old_image'];
    $new_image_name = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';

    // Get Source Path and Destination Path Of Image File to Upload File to the Image Folder in this project
    if ($new_image_name != '') {

        // Delete old image
        if ($old_image_name != '') {
            $path = '../images/food/' . $old_image_name;
            $remove = unlink($path);

            if ($remove == false) {
                $_SESSION['remove'] = "<div class='error'>Failed to Remove Food Image</div>";
                header('location:' . SITEURL . 'admin/update-food.php');
                die();
            }
        }

        // Create new image name
        $new_image_name = $_FILES['image']['name'];
        $arr_image_name = explode('.', $new_image_name);
        $ext = end($arr_image_name);
        $new_image_name = 'Food_Name_' . rand(000, 999) . '.' . $ext;

        // Create path
        $source_path = $_FILES['image']['tmp_name'];
        $destination_path = '../images/food/' . $new_image_name;

        // Upload image with these paths
        $upload = move_uploaded_file($source_path, $destination_path);

        if ($upload == false) {
            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
            header("location:" . SITEURL . 'admin/update-food.php');
            die();
        }
    }
    // Use an old image if not change 
    else {
        $new_image_name = $old_image_name;
    }

    $category_id = $_POST['category'] != '0' ? $_POST['category'] : '';
    $featured = isset($_POST['featured']) ? $_POST['featured'] : 'No';
    $active = isset($_POST['active']) ? $_POST['active'] : 'No';

    //2. SQL Query to Save the data in database
    $sql3 = "UPDATE tbl_food SET
            title='$title', 
            description='$description',
            price='$price',
            image_name='$new_image_name',
            category_id='$category_id',
            featured='$featured',
            active='$active'
            WHERE id='$id'";

    //3. Execute Query and Save Data in database
    $res3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));

    //4 Check whether the (Query is Executed) data is inserted or not and display appropriate message
    if ($res3 == TRUE) {
        // Data Inserted
        // echo "Data Inserted";
        $_SESSION['update'] = "<div class='success'>Food Updated Successfully</div>";
        // Redirect Page to Manage Admin
        header("location:" . SITEURL . 'admin/manage-food.php');
    } else {
        // echo "Insert Failed";
        $_SESSION['update'] = "<div class='error'>Failed to Update Food</div>";
        header("location:" . SITEURL . 'admin/update-food.php');
    }
}

?>