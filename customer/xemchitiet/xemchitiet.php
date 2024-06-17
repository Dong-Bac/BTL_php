
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
            <div class="container">

            <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];

                    if (htmlspecialchars($id)) {
                        $host = 'localhost';
                        $dbname = 'netflix_db';
                        $username_db = 'root';
                        $password_db = '';
                        $port = 3366;

                        try {
                            $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username_db, $password_db);
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = "SELECT * FROM movies WHERE id = :id";
                            $stmtCheck = $pdo->prepare($sql);
                            $stmtCheck->bindParam(':id', $id, PDO::PARAM_INT);
                            $stmtCheck->execute();
                            $movies = $stmtCheck->fetchAll(PDO::FETCH_ASSOC);

                            if ($movies) {
                                foreach ($movies as $movie) {
                                    echo '
                                    <h1>Netflix Film Introduction</h1>
                                    <div class="film-info">
                                        <img src="' . htmlspecialchars($movie['image']) . '" alt="' . htmlspecialchars($movie['title']) . '">
                                        <div class="film-details">
                                            <h2>' . htmlspecialchars($movie['title']) . '</h2>
                                            <p>Release Date: ' . htmlspecialchars($movie['release_date']) . '</p>
                                            <p>Description: ' . htmlspecialchars($movie['description']) . '</p>
                                            <a href="' . htmlspecialchars($movie['link']) . '">Watch on Netflix</a>
                                            <p>Duration: ' . htmlspecialchars($movie['duration']) . ' minutes</p>
                                        </div>
                                    </div>
                                    <div class="rating">
                                        Rating: ' . htmlspecialchars($movie['rating']) . '/10 on IMDB
                                    </div>
                                    ';
                                }
                            } else {
                                echo "<p>Không có phim nào được tìm thấy.</p>";
                            }
                        } catch (PDOException $e) {
                            echo "Lỗi khi kết nối đến cơ sở dữ liệu: " . $e->getMessage();
                        }

                        $pdo = null;
                    }
                } else {
                    echo "Tham số 'id' không tồn tại trong URL.";
                }
            ?>
                
              </div>
        </main>
        
    </div>
    <footer>
        <p>&copy; 2024 Netflix. All rights reserved.</p>
    </footer>
</body>
</html>

