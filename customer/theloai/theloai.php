<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /test/dangnhap/dangnhap.php");
    exit();
}

function getUserInfo($userId) {
    $host = 'localhost';
    $dbname = 'netflix_db';
    $username_db = 'root';
    $password_db = '';
    $port = 3366;

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username_db, $password_db);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT username, email FROM users WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Lỗi khi kết nối đến cơ sở dữ liệu: " . $e->getMessage();
        return false;
    }

    $pdo = null;
}

$userInfo = getUserInfo($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netflix</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <div class="wrapper">
        <nav>
            <ul class="nav-links">
                <li><a href="../menu/menu.php">Trang chủ</a></li>
                <li><a href="../gioithieu/gioithieu.php">Giới thiệu film</a></li>
                <li><a href="#">Thể loại</a>
                    <ul class="dropdown">
                        <?php
                            $host = 'localhost';
                            $dbname = 'netflix_db';
                            $username_db = 'root';
                            $password_db = '';
                            $port = 3366;

                            try {
                                $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username_db, $password_db);
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sql = "SELECT * FROM genres";
                                $stmtCheckEmail = $pdo->prepare($sql);
                                $stmtCheckEmail->execute();
                                $genres = $stmtCheckEmail->fetchAll(PDO::FETCH_ASSOC);

                                if ($genres) {
                                    foreach ($genres as $genre) {
                                        echo '<li><a href="../theloai/theloai.php?type=' . htmlspecialchars($genre['name']) . '">' . htmlspecialchars($genre['name']) . '</a></li>';
                                    }
                                } else {
                                    echo "<p>Không có thể loại nào được tìm thấy.</p>";
                                }
                            } catch(PDOException $e) {
                                echo "Lỗi khi kết nối đến cơ sở dữ liệu: " . $e->getMessage();
                            }

                            $pdo = null;
                        ?>
                    </ul>
                </li>
                <li class="search-bar">
                    <input type="text" placeholder="Tìm kiếm..."/>
                    <button>Tìm Kiếm</button>
                </li>
                <?php if ($userInfo): ?>
                    <li><a href="#">Xin chào, <?php echo htmlspecialchars($userInfo['username']); ?></a></li>
                    <li><a href="/test/dangnhap/dangnhap.php">Đăng xuất</a></li>
                <?php else: ?>
                    <li><a href="/test/dangnhap/dangnhap.php">Đăng nhập</a></li>
                    <li><a href="/test/dangxuat/dangxuat.php">Đăng ký</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <main>
            <h2>Phim hay</h2>
            <div class="product-grid">
                <div class="product">
                    <img src="kit1.jpg" alt="Kit MonsGeek MG">
                    <h3>Tên film</h3>
                    <p>Thời lượng</p>
                    <p>Đánh giá</p>
                    <a href="#">Xem chi tiết</a>
                </div>
                <div class="product">
                    <img src="kit1.jpg" alt="Kit MonsGeek MG">
                    <h3>Tên film</h3>
                    <p>Thời lượng</p>
                    <p>Đánh giá</p>
                    <a href="#">Xem chi tiết</a>
                </div>
                <div class="product">
                    <img src="kit1.jpg" alt="Kit MonsGeek MG">
                    <h3>Tên film</h3>
                    <p>Thời lượng</p>
                    <p>Đánh giá</p>
                    <a href="#">Xem chi tiết</a>
                </div>
                <div class="product">
                    <img src="kit1.jpg" alt="Kit MonsGeek MG">
                    <h3>Tên film</h3>
                    <p>Thời lượng</p>
                    <p>Đánh giá</p>
                    <a href="#">Xem chi tiết</a>
                </div>
                <div class="product">
                    <img src="kit1.jpg" alt="Kit MonsGeek MG">
                    <h3>Tên film</h3>
                    <p>Thời lượng</p>
                    <p>Đánh giá</p>
                    <a href="#">Xem chi tiết</a>
                </div>
                <div class="product">
                    <img src="kit1.jpg" alt="Kit MonsGeek MG">
                    <h3>Tên film</h3>
                    <p>Thời lượng</p>
                    <p>Đánh giá</p>
                    <a href="#">Xem chi tiết</a>
                </div>
            </div>
        </main>
        
    </div>
    <footer>
        <p>&copy; 2024 Netflix. All rights reserved.</p>
    </footer>
</body>
</html>


























