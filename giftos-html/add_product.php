<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Add Product - Giftos</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/sidebar.css" rel="stylesheet" />
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php include"sidebarAdmin.php" ?>

    <!-- Page Content -->
    <div id="content">

      <div class="container mt-4">
        <h2>Add New Product</h2>
        <form action="insertProduct.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required />
          </div>
          <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required />
          </div>
          <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" id="category" name="category_id" required>
              <?php
              include 'db.php';
              $sql = "SELECT category_id, name FROM Categories";
              $result = mysqli_query($conn, $sql);
              while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['category_id'] . '">' . $row['name'] . '</option>';
              }
              $conn->close();
              ?>
            </select>
            </div>
            <div class="form-group">
                <label for="image">Upload Image</label>
                <input type="file" class="form-control" id="image" name="image" required />
            </div>
          <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
      </div>
    </div>
  </div>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/sidebar.js"></script>
</body>

</html>
