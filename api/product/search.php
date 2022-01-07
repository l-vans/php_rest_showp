<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization, X-Requested-With');
    include_once '../../config/Database.php';
    include_once '../../models/Product.php';

    // Instatiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // initialize object
    $product = new Product($db);

    // get keywords
    $words=isset($_GET["search"]) ? $_GET["search"] : "";

    // query products
    $stmt = $product->search($words);
    $num = $stmt->rowCount();

    if($num>0){
        $product_arr=array();
        $product_arr["products"]=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $product_item=array(
                "store_id" => $store_id,
                "name" => $name,
                "description" => html_entity_decode($description),
                "price" => $price
            );

            array_push($product_arr["products"], $product_item);
        }

        // set response code - 200 OK
        http_response_code(200);
        // show products data
        echo json_encode($product_arr);
    }
    else{
        http_response_code(404);

        echo json_encode(
            array("message" => "No products found.")
        );
    }