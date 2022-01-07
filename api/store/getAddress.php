<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    include_once '../../config/Database.php';
    include_once '../../models/Store.php';
    // include_once '../../models/StoreName.php';

    // Instatiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // initialize object
    $store = new Store($db);
    // $storeName = new StoreName($db);
    // get keywords
    $store->address_id=isset($_GET["id"]) ? $_GET["id"] : "";
    // query products
    $stmt = $store->getAddress();
      // Create array
    $add_arr = array(
        // 'address_id' => $store->address_id,
        'a_name' => $store->a_name,
        'street' => $store->street,
        'city' => $store->city,
        'county' => $store->county,
        'postcode' => $store->postcode
        // 'a_name' => $store->a_name
    );

    // Make JSON
    print_r(json_encode($add_arr));
