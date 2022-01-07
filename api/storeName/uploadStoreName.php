<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/StoreName.php';

    $database = new Database();
    $db = $database->connect();

    $storeName = new StoreName($db);

    $data = json_decode(file_get_contents("php://input"));
    $storeName->store_id = $data->store_id;
    $storeName->address_id = $data->address_id;
    $storeName->name= $data->name;

    if($storeName->uploadStoreName()) {
        echo json_encode(
            array('message' => 'Store Name uploaded')
        );
    } else {
        echo json_encode(
            array('message' => 'Store Name not uploaded')
        );
    }