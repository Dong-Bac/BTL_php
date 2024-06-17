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
            <section class="intro">
                <div class="intro-content">
                    <h1>Chào mừng đến với Netflix</h1>
                    <p>Netflix là một dịch vụ phim trực tuyến hàng đầu trên thế giới, cung cấp hàng ngàn bộ phim và chương trình truyền hình trên nhiều thể loại khác nhau. Tại Netflix, bạn có thể tận hưởng trải nghiệm giải trí đa dạng, từ những bộ phim hành động, tình cảm, hài hước đến những bộ phim trinh thám và khoa học viễn tưởng. Hãy khám phá ngay và trải nghiệm niềm vui đặc biệt của bạn!</p>
                </div>
            </section>
            
            <section class="featured-movies">
                <h2>Phim nổi bật</h2>
                <div class="movies-grid">
                    <?php
                        $host = 'localhost';
                        $dbname = 'netflix_db';
                        $username_db = 'root';
                        $password_db = '';
                        $port = 3366;

                        try {
                            $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username_db, $password_db);
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = "SELECT * FROM movies ORDER BY visited DESC LIMIT 12";
                            $stmtCheckEmail = $pdo->prepare($sql);
                            $stmtCheckEmail->execute();
                            $movies = $stmtCheckEmail->fetchAll(PDO::FETCH_ASSOC);

                            if ($movies) {
                                foreach ($movies as $movie) {
                                    echo "
                                    <div class=\"movie\">
                                        <img src=\"{$movie['image']}\" alt=\"{$movie['title']}\" width=\"200px\" height=\"300px\">
                                        <h3>{$movie['title']}</h3>
                                        <p>{$movie['description']}</p>
                                    </div>
                                    ";
                                }
                            } else {
                                echo "<p>Không có phim nào được tìm thấy.</p>";
                            }
                        } catch(PDOException $e) {
                            echo "Lỗi khi kết nối đến cơ sở dữ liệu: " . $e->getMessage();
                        }

                        $pdo = null;
                    ?>
                </div>
            </section>
            
            <section class="genres">
                <h2>Thể loại phim</h2>
                <div class="genre-grid">
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
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                                if ($genres) {
                                    foreach ($genres as $genre) {
                                        echo "
                                        <div class=\"genre\">
                                            <h3>{$genre['name']}</h3>
                                            <img src=\"{$genre['image_genre']}\" alt=\"{$genre['name']}\">
                                        </div>
                                        ";
                                    }
                                } else {
                                    echo "<p>Không có thể loại nào được tìm thấy.</p>";
                                }
                            } catch(PDOException $e) {
                                echo "Lỗi khi kết nối đến cơ sở dữ liệu: " . $e->getMessage();
                            }

                            $pdo = null;
                        ?>
                    
                </div>
            </section>
        </main>
        
    </div>
    <footer>
        <p>&copy; 2024 Netflix. All rights reserved.</p>
    </footer>
</body>
</html>
