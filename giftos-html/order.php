<?php
session_start(); 
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'db.php'; 

$orderSuccess = false;
$error = '';
$product = null;
$quantity = 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['confirm_order'])) {
        $product_id = $_POST['product_id'];
        $user_id = $_SESSION['user_id'];
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1; 

        $query = "SELECT * FROM Gifts WHERE gift_id = '$product_id'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
            $total_price = $product['price'] * $quantity;
            
            $orderQuery = "INSERT INTO orders (user_id, gift_id, quantity, total_price, status) 
                        VALUES ('$user_id', '$product_id', '$quantity', '$total_price', 2)";
            if (mysqli_query($conn, $orderQuery)) {
                $orderSuccess = true; 
            } else {
                $error = "Failed to place the order. Please try again.";
            }
        } else {
            $error = "Product not found.";
        }
    } elseif (isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];

        $query = "SELECT * FROM Gifts WHERE gift_id = '$product_id'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
        } else {
            $error = "Product not found.";
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Order</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mt-5">
    <?php if ($orderSuccess): ?>
        <div class="alert alert-success">
            Your order has been placed successfully with Cash on Delivery. Thank you for shopping with us!
        </div>
        <a href="shop.php" class="btn btn-primary">Continue Shopping</a>
    <?php else: ?>
        <?php if ($product): ?>
            <h2>Order Summary</h2>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo  ($product['name']); ?></h5>
                    <p class="card-text">Price: ₹<?php echo  ($product['price']); ?></p>
                    <p class="card-text">Quantity: <?php echo  ($quantity); ?></p>
                    <p class="card-text">Total Price: ₹<?php echo  ($product['price'] * $quantity); ?></p>
                    <p class="card-text">Payment Method: Cash on Delivery</p>
                    <form action="order.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo  ($product_id); ?>">
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input type="number" name="quantity" id="quantity" value="<?php echo  ($quantity); ?>" min="1" class="form-control">
                        </div>
                        <button type="submit" name="confirm_order" class="btn btn-success">Confirm Order</button>
                    </form>
                </div>
            </div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger">
                <?php echo  ($error); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script src="js/bootstrap.js"></script>
</body>
</html>
