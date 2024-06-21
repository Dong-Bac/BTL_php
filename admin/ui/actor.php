<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="">
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../../css/admin.min.css" rel="stylesheet">
    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body>
    <?php
        include_once "../../config/connect.php";
        include_once "../../dao/ActorDao.php";

        $dao = new ActorDao($conn);
        $data = $dao->getActors();
    ?>
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Actor</h6>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Birthday</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php
                    foreach($data as $item){
                        echo 
                        '<tbody>
                        <tr>
                        <td>'.$item['id'].'</td>
                        <td>'.$item['name'].'</td>
                        <td>'.$item['birthdate'].'</td>
                        <td><button onclick="Update('.$item['id'].')">Update</button></td>
                        <td><button onclick="Delete('.$item['id'].')">Delete</button></td>
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
                            <th><button onclick="Add()">Add</button></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script>
        function Update(id){
            alert(id)
        }
        function Delete(id){

        }
        function Add(){
        }
    </script>
</body>

</html>