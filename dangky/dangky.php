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
                <h1>Đăng Ký</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <label for="username">Tên đăng nhập:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Xác nhận mật khẩu:</label>
                        <input type="password" id="confirm-password" name="confirm-password" required>
                    </div>
                    <button type="submit">Đăng Ký</button>
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
// Kiểm tra nếu form đã được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form và kiểm tra tính hợp lệ
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // Kiểm tra xác nhận mật khẩu
    if ($password != $confirmPassword) {
        echo "<alert>Xác nhận mật khẩu không khớp!</alert>";
        exit();
    }

    // Mã hóa mật khẩu bằng bcrypt
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

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

        // Kiểm tra xem tên đăng nhập đã tồn tại chưa
        $sqlCheckUsername = "SELECT COUNT(*) AS count FROM users WHERE username = :username";
        $stmtCheckUsername = $pdo->prepare($sqlCheckUsername);
        $stmtCheckUsername->bindParam(':username', $username);
        $stmtCheckUsername->execute();
        $rowUsername = $stmtCheckUsername->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra xem email đã tồn tại chưa
        $sqlCheckEmail = "SELECT COUNT(*) AS count FROM users WHERE email = :email";
        $stmtCheckEmail = $pdo->prepare($sqlCheckEmail);
        $stmtCheckEmail->bindParam(':email', $email);
        $stmtCheckEmail->execute();
        $rowEmail = $stmtCheckEmail->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra kết quả và xử lý
        if ($rowUsername['count'] > 0) {
            echo "<alert>Tên đăng nhập đã tồn tại. Vui lòng chọn tên đăng nhập khác.</alert>";
        } elseif ($rowEmail['count'] > 0) {
            echo "<alert>Email đã tồn tại trong hệ thống. Vui lòng sử dụng email khác.</alert>";
        } else {
            // Thực hiện chèn người dùng vào bảng `users`
            $sqlInsertUser = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmtInsertUser = $pdo->prepare($sqlInsertUser);
            $stmtInsertUser->bindParam(':username', $username);
            $stmtInsertUser->bindParam(':email', $email);
            $stmtInsertUser->bindParam(':password', $hashedPassword);
            $stmtInsertUser->execute();

            // Lấy ID người dùng vừa chèn
            $userId = $pdo->lastInsertId();

            // Thêm người dùng vào bảng `userroles` với role_id là 2 (audience)
            $sqlInsertUserRole = "INSERT INTO userroles (user_id, role_id) VALUES (:user_id, 2)";
            $stmtInsertUserRole = $pdo->prepare($sqlInsertUserRole);
            $stmtInsertUserRole->bindParam(':user_id', $userId);
            $stmtInsertUserRole->execute();

            // Chuyển hướng đến trang đăng nhập
            header("Location: /test/dangnhap/dangnhap.php");
            exit();
        }
    } catch(PDOException $e) {
        echo "Lỗi khi lưu dữ liệu: " . $e->getMessage();
    }

    // Đóng kết nối
    $pdo = null;
}
?>
