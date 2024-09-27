<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Admin Dashboard - Giftos</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/sidebar.css" rel="stylesheet" />
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
</head>
<body>
  <div class="wrapper">
    <?php include"sidebarAdmin.php" ?>
    <div id="content">
      <div class="container mt-4">
        <h2>Admin Dashboard</h2>
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Total Products</h5>
                <p class="card-text">
                  <?php
                  include 'db.php';
                  $sql = "SELECT COUNT(*) as total FROM Gifts";
                  $result = mysqli_query($conn, $sql); 
                  $data = mysqli_fetch_assoc($result);  
                  echo $data['total'];  
                  mysqli_close($conn);
                  ?>
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Total Orders</h5>
                <p class="card-text">
                  <?php
                  include 'db.php';
                  $sql = "SELECT COUNT(*) as total FROM Orders";
                  $result = mysqli_query($conn, $sql); 
                  $data = mysqli_fetch_assoc($result);
                  echo $data['total'];
                  $conn->close();
                  ?>
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <p class="card-text">
                  <?php
                  include 'db.php';
                  $sql = "SELECT COUNT(*) as total FROM Users";
                  $result = mysqli_query($conn, $sql); 
                  $data = mysqli_fetch_assoc($result);
                  echo $data['total'];
                  $conn->close();
                  ?>
                </p>
              </div>
            </div>
          </div>
        </div>
        <h3 class="mt-4">Recent Orders</h3>
        <table class="table">
          <thead>
            <tr>
              <th>User ID</th>
              <th>Gift ID</th>
              <th>Quantity</th>
              <th>Total Price</th>
              <th>Order Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include 'db.php';
            $sql = "SELECT * FROM Orders ORDER BY order_date DESC LIMIT 5";
            $result = mysqli_query($conn, $sql); 
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo '
                <tr>
                  <td>' . $row["user_id"] . '</td>
                  <td>' . $row["gift_id"] . '</td>
                  <td>' . $row["quantity"] . '</td>
                  <td>₹' . $row["total_price"] . '</td>
                  <td>' . $row["order_date"] . '</td>
                  <td>' . ($row["status"] == 1 ? 'Pending' : ($row["status"] == 2 ? 'Completed' : 'Cancelled')) . '</td>
                </tr>';
              }
            } else {
              echo "<tr><td colspan='7'>No orders found</td></tr>";
            }
            $conn->close();
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