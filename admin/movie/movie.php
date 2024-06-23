<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../../css/admin.min.css" rel="stylesheet">
    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    include_once "../../config/connect.php";
    include_once "../../dao/MovieDao.php";
    include_once "../../dao/MovieActorDao.php";
    include_once "../../dao/MovieGenreDao.php";
    include_once "../../dao/DirectorDao.php";
    include_once "../../dao/ActorDao.php";
    include_once "../../dao/GenreDao.php";

    $dao = new MovieDao($conn);
    $movieActorDao = new MovieActorsDao($conn);
    $movieGenreDao = new MovieGenresDao($conn);
    $directorDao = new DirectorsDao($conn);
    $actorDao = new ActorDao($conn);
    $genreDao = new GenresDao($conn);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST["action"];
        if ($action == 'add') {
            print_r($_POST);
            $image = $_POST["image"];
            $tittle = $_POST["title"];
            $release_date = $_POST["release_date"];
            $description = $_POST["description"];
            $director_id = $_POST["director"];
            $link = $_POST["link"];
            $duration = $_POST["duration"];
            $actors = $_POST['actors'];
            $genres = $_POST['genres'];
            $last_id = $dao->addMovie($image, $tittle, $release_date, $description, $director_id, $link, $duration);
            foreach ($actors as $a) {
                $movieActorDao->addMovieActor($last_id, $a);
            }
            foreach ($genres as $g) {
                $movieGenreDao->addMovieGenre($last_id, $g);
            }
        }
        if ($action == 'update') {
            $id = $_POST["id"];
            $name = $_POST["name"];
            $birthdate = $_POST["birthdate"];
            $dao->updateMovie($id, $name, $birthdate);
        }
        if ($action == 'delete') {
            $id = $_POST["id"];
            $dao->deleteMovie($id);
        }
    }
    $data = $dao->getMovies();
    $listDirector = $directorDao->getDirectors();
    $listActor = $actorDao->getActors();
    $listGenre = $genreDao->getGenres();
    ?>
    <div id="container">
        <div class="col-lg-12 mt-3">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Movie</h6>
                </div>
                <div class="table-responsive p-3 d-flex justify-content-center">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th class="col-md-1">Id</th>
                                <th class="col-md-1">Image</th>
                                <th class="col-md-1">Title</th>
                                <th class="col-md-1">Release Date</th>
                                <th class="col-md-4">Description</th>
                                <th class="col-md-1">Link</th>
                                <th class="col-md-1">Duration</th>
                                <th class="col-md-1"></th>
                                <th class="col-md-1"></th>
                            </tr>
                        </thead>
                        <?php
                        foreach ($data as $item) {
                            $list_genre = $movieGenreDao->getMovieGenres($item['id']);
                            $genrestr = "";
                            $genreIds = "";
                            foreach ($list_genre as $i) {
                                $genrestr .= " " . $i['genre_name'] . ", ";
                                $genreIds .= $i['genre_id'] . ",";
                            }
                            $genrestr = rtrim($genrestr, " ");
                            $genrestr = rtrim($genrestr, ",");
                            $genreIds = rtrim($genreIds, ",");

                            $list_actor = $movieActorDao->getMovieActors($item['id']);
                            $actorstr = "";
                            $actorIds = "";
                            foreach ($list_actor as $i) {
                                $actorstr .= " " . $i['actor_name'] . ", ";
                                $actorIds .= $i['actor_id'] . ",";
                            }
                            $actorstr = rtrim($actorstr, " ");
                            $actorstr = rtrim($actorstr, ",");
                            $actorIds = rtrim($actorIds, ",");
                            
                            echo
                            '<tbody>
                            <tr>
                            <td>' . $item['id'] . '</td>
                            <td> <image src ="' . $item['image'] . '" width="120" height="90"></td>
                            <td>' . $item['title'] . '</td>
                            <td>' . $item['release_date'] . '</td>
                            <td>'
                                . $item['description'] . '<br>' .
                                'Director: ' . $item['director_name'] . '<br>' .
                                'Actor: ' . $actorstr . '<br>' .
                                'Genre: ' . $genrestr . '<br>' .
                                '</td>
                            <td>' . $item['link'] . '</td>
                            <td>' . $item['duration'] . '</td>
                            <td><button class="btn btn-primary" onclick="Update('
                                . "'" . $item['id'] . "'" .
                                ','
                                . "'" . $item['image'] . "'" .
                                ','
                                . "'" . $item['title'] . "'" .
                                ','
                                . "'" . $item['release_date'] . "'" .
                                ','
                                . "'" . $item['description'] . "'" .
                                ','
                                . "'" . $item['director_id'] . "'" .
                                ','
                                . "'" . $item['link'] . "'" .
                                ','
                                . "'" . $item['duration'] . "'" .
                                ','
                                . "'" . $actorIds . "'" .
                                ','
                                . "'" . $genreIds . "'" .
                                ')">Update</button></td>
                            <td><button class="btn btn-primary" onclick="Delete(' . $item['id'] . ')">Delete</button></td>
                            </tr>
                            </tbody>';
                        }
                        ?>
                        <thead class="thead-light">
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th class="d-flex justify-content-center"><button class="btn btn-primary" onclick="Add()">Add</button></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div id="wrap_addform" class="wrap-form form-overlay">
            <div id="div_addform" class="card" style="width: 600px;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Add Form</h6>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="Name">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter Title">
                        </div>
                        <div class="form-group">
                            <label for="Image">Image</label>
                            <input type="url" class="form-control" name="image" placeholder="https://???">
                        </div>
                        <div class="form-group">
                            <label for="releaseDate">Release Date</label>
                            <input type="date" class="form-control" name="release_date">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" name="description">
                        </div>
                        <div class="form-group">
                            <label for="director">Director: </label>
                            <select name="director">
                                <?php
                                foreach ($listDirector as $d) {
                                    echo '<option value="' . $d["id"] . '">' . $d["name"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="actor">Actors: </label>
                            <?php
                            foreach ($listActor as $a) {
                                echo '<input id="actor' . $a['id'] . '" type="checkbox" name="actors[]" value="' . $a['id'] . '"> ' . $a['name'] . "   ";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="actor">Genres: </label>
                            <?php
                            foreach ($listGenre as $g) {
                                echo '<input id="genre' . $g['id'] . '" type="checkbox" name="genres[]" value="' . $g['id'] . '"> ' . $g['name'] . "   ";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="link">Link</label>
                            <input type="url" class="form-control" name="link">
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration</label>
                            <input type="number" class="form-control" name="duration">
                        </div>
                        <button type="submit" name="action" class="btn btn-primary" value="add">Add</button>
                    </form>
                </div>
            </div>
        </div>

        <div id="wrap_updateform" class="wrap-form form-overlay">
            <div id="div_updateform" class="card" style="width: 600px;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Update Form</h6>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input id="id_update" name="id" hidden>
                        <div class="form-group">
                            <label for="Name">Title</label>
                            <input id="title_update" type="text" class="form-control" name="title" placeholder="Enter Title">
                        </div>
                        <div class="form-group">
                            <label for="Image">Image</label>
                            <input id="image_update" type="url" class="form-control" name="image" placeholder="https://???">
                        </div>
                        <div class="form-group">
                            <label for="releaseDate">Release Date</label>
                            <input id="releaseDate_update" type="date" class="form-control" name="release_date">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input id="description_update" type="text" class="form-control" name="description">
                        </div>
                        <div class="form-group">
                            <label for="director">Director: </label>
                            <select name="director">
                                <?php
                                foreach ($listDirector as $d) {
                                    echo '<option id="director'.$d["id"].'" value="' . $d["id"] . '">' . $d["name"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="actor">Actors: </label>
                            <?php
                            foreach ($listActor as $a) {
                                echo '<input id="actor' . $a['id'] . '" type="checkbox" name="actors[]" value="' . $a['id'] . '" > ' . $a['name'] . "   ";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="actor">Genres: </label>
                            <?php
                            foreach ($listGenre as $g) {
                                echo '<input id="genre' . $g['id'] . '" type="checkbox" name="genres[]" value="' . $g['id'] . '"> ' . $g['name'] . "   ";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="link">Link</label>
                            <input id="link_update" type="url" class="form-control" name="link">
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration</label>
                            <input id="duration_update" type="number" class="form-control" name="duration">
                        </div>
                        <button type="submit" name="action" class="btn btn-primary" value="update">Update</button>
                    </form>
                </div>
            </div>
        </div>

        <div id="wrap_deleteform" class="wrap-form form-overlay">
            <div id="div_deleteform" class="card" style="width: 600px;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Delete Form</h6>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input id="id_delete" name="id" hidden>
                        Are you want delete this item?
                        <br>
                        <br>
                        <button type="submit" name="action" class="btn btn-primary" value="delete">Delete</button>
                        <button type="submit" class="btn btn-primary" onclick="dimissDelete()">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>