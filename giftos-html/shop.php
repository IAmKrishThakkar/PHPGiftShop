<?php
session_start(); 
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

  <title>
    Giftos
  </title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
</head>

<body>
  <div class="hero_area">

    <header class="header_section">
      <?php include "navbar.php"; ?>
    </header>

  </div>

  <form action="order.php" accept="post">
    <section class="shop_section layout_padding">
      <div class="container">
        <div class="heading_container heading_center">
          <h2>Latest Products</h2>
        </div>
        <div class="row">
          <?php
          include 'db.php';
          $sql = "SELECT * FROM Gifts";
          $result = mysqli_query($conn, $sql);

          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo '
              <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box">
                  <a href="">
                    <div class="img-box">
                      <img src="' . $row["image_url"] . '" alt="">
                    </div>
                    <div class="detail-box">
                      <h6>' . $row["name"] . '</h6>
                      <h6>Price <span>₹' . $row["price"] . '</span></h6>
                    </div>
                    <div class="btn-box text-center mt-2">
                      <form action="order.php" method="post">
                        <input type="hidden" name="product_id" value="' . $row["gift_id"] . '">
                        <button type="submit" class="btn" name="cartTo">Add to Cart</button>
                      </form>
                    </div>
                    <div class="new">
                      <span>New</span>
                    </div>
                  </a>
                </div>
              </div>';
            }
          } else {
            echo "No products found.";
          }

          $conn->close();
          ?>
        </div>
      </div>
    </section>
  </form>

   


  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="js/custom.js"></script>

</body>

</html>