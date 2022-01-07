<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Product.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate product object
    $product = new Product($db);

    //Get raw product data
    $data = json_decode(file_get_contents("php://input"));
    $product->product_id = $data->product_id;
    $product->store_id = $data->store_id;
    $product->name = $data->name;
    $product->description = $data->description;
    $product->type = $data->type;
    $product->model = $data->model;
    $product->brand = $data->brand;
    $product->color = $data->color;
    $product->model_number = $data->model_number;
    $product->version = $data->version;
    $product->price = $data->price;

    // Create product
    if($product->create()) {
        echo json_encode(
            array('message' => 'Product created')
        );
    } else {
        echo json_encode(
            array('message' => 'Product not created')
        );
    }