<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    include_once '../../models/Store.php';
    $store = new Store($db);