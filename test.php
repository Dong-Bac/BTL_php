<?php
    include("./config/connect.php");
    include("./dao/ActorDao.php");
    $dao = new ActorDao($conn);
    print_r($dao->getActorById(1));