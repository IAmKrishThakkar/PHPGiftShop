<?php
session_start();
include 'db.php'; 

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $table = ($role == 'admin') ? 'admin' : 'users';
    $query = "SELECT * FROM $table WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $role;
        $_SESSION['user_id'] = $row['user_id'];

        if ($role == 'admin') {
            header('Location: admin.php');
        } else {
            header('Location: shop.php');
        }
        exit();
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="css/logincss.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
</head>
<body>

<div class="container mt-3">
    <div class="login_section">
        <div class="login_box">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" id="admin-tab" data-bs-toggle="tab" href="#admin">Admin Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="user-tab" data-bs-toggle="tab" href="#user">User Login</a>
                </li>
            </ul>
            <div><br></br></div>
            <div class="tab-content">
                <div id="admin" class="tab-pane fade show active">
                    <h3>Admin Login</h3>
                    <form action="login.php" method="post">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <input type="hidden" name="role" value="admin">
                        <button type="submit">Login</button>
                    </form>
                </div>
                <div id="user" class="tab-pane fade">
                    <h3>User Login</h3>
                    <form action="login.php" method="post">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <input type="hidden" name="role" value="user">
                        <button type="submit">Login</button>
                    </form>
                    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
                </div>
            </div>
            <?php if ($error): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
