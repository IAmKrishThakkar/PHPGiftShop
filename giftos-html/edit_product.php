<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'db.php';
$product = null;
$error = '';
$success = false;
if (isset($_GET['id'])) {
    $gift_id = $_GET['id'];
    $query = "SELECT * FROM Gifts WHERE gift_id = '$gift_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        $error = "Product not found.";
    }
} else {
    $error = "No product ID provided.";
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $image_url = $_POST['image_url'];

    if (empty($name) || empty($price)  || empty($category_id) || empty($image_url)) {
        $error = "All fields are required.";
    } else {
        $update_query = "UPDATE Gifts 
                         SET name = '$name', price = '$price', category_id = '$category_id', image_url = '$image_url'
                         WHERE gift_id = '$gift_id'";

        if (mysqli_query($conn, $update_query)) {
            $success = true;
        } else {
            $error = "Failed to update the product. Please try again.";
        }
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product - Giftos</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mt-5">
    <?php if ($success): ?>
        <div class="alert alert-success">
            Product updated successfully.
        </div>
        <a href="manage_products.php" class="btn btn-primary">Back to Manage Products</a>
    <?php else: ?>
        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?php echo   ($error); ?>
            </div>
        <?php endif; ?>
        <?php if ($product): ?>
            <h2>Edit Product</h2>
            <form action="edit_product.php?id=<?php echo   ($gift_id); ?>" method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" value="<?php echo   ($product['name']); ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="text" name="price" id="price" value="<?php echo   ($product['price']); ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="category_id">Category:</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <?php
                        include 'db.php';
                        $category_query = "SELECT * FROM Categories";
                        $category_result = mysqli_query($conn, $category_query);
                        while ($category = mysqli_fetch_assoc($category_result)) {
                            $selected = $product['category_id'] == $category['category_id'] ? 'selected' : '';
                            echo '<option value="' .   ($category['category_id']) . '" ' . $selected . '>' .   ($category['name']) . '</option>';
                        }
                        mysqli_close($conn);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image_url">Image URL:</label>
                    <input type="text" name="image_url" id="image_url" value="<?php echo   ($product['image_url']); ?>" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Product</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>
</div>
<script src="js/bootstrap.js"></script>
</body>
</html>