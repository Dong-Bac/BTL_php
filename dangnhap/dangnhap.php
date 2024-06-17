<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netflix</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="wrapper">
        <nav>
            <ul class="nav-links">
                <li><a href="#">Trang chủ</a></li>
                <li><a href="#">Giới thiệu film</a></li>
                <li><a href="#">Thể loại</a>
                    <ul class="dropdown">
                        <li><a href="#">Tình cảm</a></li>
                        <li><a href="#">Hài hước</a></li>
                        <li><a href="#">Trinh thám</a></li>
                    </ul>
                </li>
                <li class="search-bar">
                    <input type="text" placeholder="Tìm kiếm..."/>
                    <button>Tìm Kiếm</button>
                </li>
                <li><a href="#">Đăng nhập</a></li>
                <li><a href="#">Đăng ký</a></li>
            </ul>
        </nav>
        <main>
            <div class="container">
                <h1>Đăng Nhập</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit">Đăng nhập</button>
                </form>
            </div>
        </main>
    </div>
    <footer>
        <p>&copy; 2024 Netflix. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
session_start();

// Kiểm tra nếu form đã được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Thực hiện kết nối đến cơ sở dữ liệu
    $host = 'localhost';
    $dbname = 'netflix_db';
    $username_db = 'root';
    $password_db = '';
    $port = 3366; 

    try {
        // Tạo kết nối PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username_db, $password_db);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Kiểm tra xem email có tồn tại trong hệ thống không
        $sqlCheckEmail = "SELECT id, username, password FROM users WHERE email = :email";
        $stmtCheckEmail = $pdo->prepare($sqlCheckEmail);
        $stmtCheckEmail->bindParam(':email', $email);
        $stmtCheckEmail->execute();
        $user = $stmtCheckEmail->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Đăng nhập thành công, lưu thông tin người dùng vào phiên
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Chuyển hướng đến trang chủ
            header("Location: /test/customer/menu/menu.php");
            exit();
        } else {
            echo "<script>alert('Email hoặc mật khẩu không đúng!');</script>";
        }
    } catch(PDOException $e) {
        echo "Lỗi khi kết nối đến cơ sở dữ liệu: " . $e->getMessage();
    }

    // Đóng kết nối
    $pdo = null;
}
?>
