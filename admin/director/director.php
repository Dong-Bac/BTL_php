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
    include_once "../../dao/DirectorDao.php";

    $dao = new DirectorsDao($conn);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST["action"];
        if ($action == 'add') {
            $name = $_POST["name"];
            $birthdate = $_POST["birthdate"];
            $dao->addDirector($name, $birthdate);
        }
        if ($action == 'update') {
            $id = $_POST["id"];
            $name = $_POST["name"];
            $birthdate = $_POST["birthdate"];
            $dao->updateDirector($id, $name, $birthdate);
        }
        if ($action == 'delete') {
            $id = $_POST["id"];
            $dao->deleteDirector($id);
        }
    }
    $data = $dao->getDirectors();

    ?>
    <div id="container">
        <div class="col-lg-12 mt-3">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Director</h6>
                </div>
                <div class="table-responsive p-3 d-flex justify-content-center">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th class="col-md-2">Id</th>
                                <th class="col-md-4">Name</th>
                                <th class="col-md-4">Birthday</th>
                                <th class="col-md-1"></th>
                                <th class="col-md-1"></th>
                            </tr>
                        </thead>
                        <?php
                        foreach ($data as $item) {
                            echo
                            '<tbody>
                            <tr>
                            <td>' . $item['id'] . '</td>
                            <td>' . $item['name'] . '</td>
                            <td>' . $item['birthdate'] . '</td>
                            <td><button class="btn btn-primary" onclick="Update('
                             . "'" . $item['id'] . "'" .
                              ',' 
                             . "'" . $item['name'] . "'" . 
                             ',' 
                             . "'" . $item['birthdate'] . "'" .
                             ',' 
                             . "'" . $item['address'] . "'" .
                             ',' 
                             . "'" . $item['age'] . "'" .
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
                            <label for="Name">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="Birthdate">Birthdate</label>
                            <input type="date" class="form-control" name="birthdate">
                        </div>
                        <button type="submit" name="action" class="btn btn-primary" value="add" value="2024-06-25">Add</button>
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
                            <label for="Name">Name</label>
                            <input id="nameUpdate" type="text" class="form-control" name="name" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="Birthdate">Birthdate</label>
                            <input id="birthdateUpdate" type="date" class="form-control" name="birthdate" placeholder="Enter name" value="2024-06-25">
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