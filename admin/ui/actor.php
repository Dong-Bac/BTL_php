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
    include_once "../../dao/ActorDao.php";

    $dao = new ActorDao($conn);
    $data = $dao->getActors();
    ?>
    <div class="col-lg-12 mt-3">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Actor</h6>
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
                        <td><button class="btn btn-primary" onclick="Update(' . $item['id'] . ')">Update</button></td>
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
    <div id="wrap_addform" class="col-lg-12 wrap-form">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Add Form</h6>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="Name">Name</label>
                        <input type="text" class="form-control" id="text" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="Birthdate">Birthdate</label>
                        <input type="date" class="form-control" id="text" placeholder="Enter name">
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
    <div id="wrap_updateform" class="col-lg-12 wrap-form">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Update Form</h6>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="Name">Name</label>
                        <input type="text" class="form-control" id="text" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="Birthdate">Birthdate</label>
                        <input type="date" class="form-control" id="text" placeholder="Enter name">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

    <div id="wrap_deleteform" class="col-lg-12 wrap-form">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Delete Form</h6>
            </div>
            <div class="card-body">
                <form>
                    Are you want delete this item?
                    <br>
                    <br>
                    <button type="submit" class="btn btn-primary">Delete</button>
                    <button type="submit" class="btn btn-primary">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>