<?php include ('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br />
        <br />

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'].'<br/><br/><br/>';
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'].'<br/><br/><br/>';
            unset($_SESSION['upload']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" placeholder="Enter Food Title"></td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td><textarea cols="30" rows="5" name="description" placeholder="Enter Food Description"></textarea></td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td><input type="number" name="price" placeholder="Enter Food Price"></td>
                </tr>

                <tr>
                    <td>File Image: </td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                            if ($res == TRUE) {
                                $count = mysqli_num_rows($res);

                                if ($count > 0) {
                                    while ($rows = mysqli_fetch_assoc($res)) {
                                        $id = $rows['id'];
                                        $title = $rows['title'];
                                        ?>
                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
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
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
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
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_name = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
    // Get Source Path and Destination Path Of Image File to Upload File to the Image Folder in this project
    if ($image_name != '') {
        $arr_image_name = explode('.', $image_name);
        $ext = end($arr_image_name);
        $image_name = 'Food_Name_' . rand(000, 999) . '.' . $ext;

        $source_path = $_FILES['image']['tmp_name'];
        $destination_path = '../images/food/' . $image_name;

        $upload = move_uploaded_file($source_path, $destination_path);

        if ($upload == false) {
            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
            header("location:" . SITEURL . 'admin/add-food.php');
            die();
        }
    }
    $category_id = $_POST['category'] != '0' ? $_POST['category'] : '';
    $featured = isset($_POST['featured']) ? $_POST['featured'] : 'No';
    $active = isset($_POST['active']) ? $_POST['active'] : 'No';

    //2. SQL Query to Save the data in database
    $sql2 = "INSERT INTO `tbl_food`(`title`, `description`, `price`, `image_name`, `category_id`, `featured`, `active`)
        VALUES ('$title','$description','$price','$image_name','$category_id','$featured','$active')";

    //3. Execute Query and Save Data in database
    $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

    //4 Check whether the (Query is Executed) data is inserted or not and display appropriate message
    if ($res2 == TRUE) {
        // Data Inserted
        // echo "Data Inserted";
        $_SESSION['add'] = "<div class='success'>Food Added Successfully</div>";
        // Redirect Page to Manage Admin
        header("location:" . SITEURL . 'admin/manage-food.php');
    } else {
        // echo "Insert Failed";
        $_SESSION['add'] = "<div class='error'>Failed to Add Food</div>";
        header("location:" . SITEURL . 'admin/add-food.php');
    }
}

?>