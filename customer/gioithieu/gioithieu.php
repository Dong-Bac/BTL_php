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
                <li><a href="../gioithieu/gioithieu.php?type=gioithieu">Giới thiệu film</a></li>
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
                                        echo '<li><a href="../gioithieu/gioithieu.php?type=' . htmlspecialchars($genre['name']) . '">' . htmlspecialchars($genre['name']) . '</a></li>';
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
                    <form method="GET" action="">
                        <input type="text" name="query" placeholder="Tìm kiếm..." value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>"/>
                        <button type="submit">Tìm Kiếm</button>
                    </form>
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
        <main>
            <?php
                // Kiểm tra nếu có tham số type từ URL
                if (isset($_GET['type'])) {
                    $type = $_GET['type'];
                    if (htmlspecialchars($type) == 'gioithieu') {
                        echo '<h2>Phim hay</h2>';
                        // Hiển thị tất cả phim nếu type là 'gioithieu'
                        $sql = "SELECT * FROM movies";
                    } else {
                        echo '<h2>' . htmlspecialchars($type) . '</h2>';
                        // Hiển thị phim theo thể loại được chọn
                        $sql = "SELECT * FROM movies 
                                INNER JOIN moviegenres ON movies.id = moviegenres.movie_id 
                                INNER JOIN genres ON genres.id = moviegenres.genre_id 
                                WHERE genres.name = :type";
                    }
                    
                    // Thực hiện truy vấn và hiển thị danh sách phim
                    try {
                        $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username_db, $password_db);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt = $pdo->prepare($sql);
                        if (isset($type) && htmlspecialchars($type) != 'gioithieu') {
                            $stmt->bindParam(':type', $type);
                        }
                        $stmt->execute();
                        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Hiển thị các phim
                        if ($movies) {
                            echo '<div class="product-grid">';
                            foreach ($movies as $movie) {
                                echo '
                                <div class="product">
                                    <img src="' . htmlspecialchars($movie['image']) . '" alt="' . htmlspecialchars($movie['title']) . '">
                                    <h3>' . htmlspecialchars($movie['title']) . '</h3>
                                    <p>Thời lượng: ' . htmlspecialchars($movie['duration']) . '</p>
                                    <p>Đánh giá: ' . htmlspecialchars($movie['rating']) . '</p>
                                    <a href="../xemchitiet/xemchitiet.php?id=' . htmlspecialchars($movie['id']) . '">Xem chi tiết</a>
                                </div>
                                ';
                            }
                            echo '</div>'; // Đóng div.product-grid
                        } else {
                            echo "<p>Không có phim nào được tìm thấy.</p>";
                        }
                    } catch (PDOException $e) {
                        echo "Lỗi khi kết nối đến cơ sở dữ liệu: " . $e->getMessage();
                    }

                    $pdo = null;
                } else {
                    echo "<p>Tham số 'type' không tồn tại trong URL.</p>";
                }
            ?>
        </main>
        
    </div>
    <footer>
        <p>&copy; 2024 Netflix. All rights reserved.</p>
    </footer>
</body>
</html>

























