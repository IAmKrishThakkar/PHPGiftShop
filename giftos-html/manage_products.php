<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Products - Giftos</title>
  <link rel="stylesheet" href="css/bootstrap.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/sidebar.css" />
  <link rel="icon" href="images/favicon.png" type="image/x-icon">
</head>
<body>
  <div class="wrapper">
    <?php include 'sidebarAdmin.php'; ?>
    <div id="content">
      <div class="container mt-4">
        <h2>Manage Products</h2>
        <table class="table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Price</th>
              <th>Categories</th>
              <th>Image</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include 'db.php';
            $sql = "SELECT * FROM Gifts";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
              $category_id = $row["category_id"];
              $category_sql = "SELECT name FROM Categories WHERE category_id = $category_id";
              $category_result = mysqli_query($conn, $category_sql);
              $category = mysqli_fetch_assoc($category_result);
              
              echo '<tr>
                <td>' .   ($row["name"]) . '</td>
                <td>₹' .   ($row["price"]) . '</td>
                <td>' .   ($category['name']) . '</td>
                <td><img src="' .   ($row["image_url"]) . '" alt="Product Image" width="100"></td>
                <td>
                  <a href="edit_product.php?id=' . urlencode($row["gift_id"]) . '" class="btn btn-warning btn-sm">Edit</a>
                  <a href="manage_products.php?delete=' . urlencode($row["gift_id"]) . '" class="btn btn-danger btn-sm">Delete</a>
                </td>
              </tr>';
            }
            if (isset($_GET['delete'])) {
              $gift_id = $_GET['delete'];
              $delete_sql = "DELETE FROM Gifts WHERE gift_id = $gift_id";
              $delete_sql1 = "DELETE FROM orders WHERE gift_id = $gift_id";
              $result=mysqli_query($conn,$delete_sql1);
              if (mysqli_query($conn, $delete_sql)) {
                echo '<script>alert("Product deleted successfully!"); window.location.href="manage_products.php";</script>';
              } else {
                echo '<script>alert("Error deleting product.");</script>';
              }
            }
            mysqli_close($conn);
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/sidebar.js"></script>
</body>
</html>