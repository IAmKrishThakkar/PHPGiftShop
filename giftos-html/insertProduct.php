<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    $target_dir = "uploads/"; 
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

                $sql = "INSERT INTO Gifts (name, price, category_id, image_url) 
                    VALUES ('$name', '$price', '$category_id', '$target_file')";

            if (mysqli_query($conn, $sql)) {
                echo "New product added successfully.";
                header('Location: manage_products.php');
                exit();
            } else {
                echo "Error: " . $sql . "<br>" .mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
