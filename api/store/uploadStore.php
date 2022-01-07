<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Store.php';

    $database = new Database();
    $db = $database->connect();

    $store = new Store($db);

    $data = json_decode(file_get_contents("php://input"));
    $store->address_id = $data->address_id;
    $store->street = $data->street;
    $store->city = $data->city;
    $store->county = $data->county;
    $store->postcode = $data->postcode;

    if($store->uploadStore()) {
        echo json_encode(
            array('message' => 'Store uploaded')
        );
    } else {
        echo json_encode(
            array('message' => 'Store not uploaded')
        );
    }