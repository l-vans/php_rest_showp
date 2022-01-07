<?php
    class Product {
        //DB STUFF 
        private $conn;
        private $table = 'product';
        private $table2 = 'store_address';
        private $table3 = 'store';
        //Product properties
        public $product_id;
        public $store_id;
        public $name;
        public $description;
        public $type;
        public $model;
        public $brand;
        public $color;
        public $model_number;
        public $version;
        public $price;
        public $word;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }
        // Get Single Post

        
        //Get Products
        public function read() {
            // Create query
            $query = 'SELECT
                    p.product_id,
                    a.address_id as store_id,
                    p.name,
                    p.description,
                    p.type,
                    p.model,
                    p.brand,
                    p.color,
                    p.model_number,
                    p.version,
                    p.price
                FROM
                    ' . $this->table . ' p
                LEFT JOIN
                    store_address a ON p.store_id = a.address_id';
                    
            // Prepared statement
            $stmt = $this->conn->prepare($query);

            // Execute
            $stmt->execute();

            return $stmt;
        }

        public function create() {
            $query = 'INSERT INTO ' . 
                    $this->table . ' 
                    SET
                    product_id = :product_id,
                    store_id = :store_id,
                    name = :name,
                    description = :description,
                    type = :type, 
                    model = :model, 
                    brand = :brand, 
                    color = :color, 
                    model_number = :model_number, 
                    version = :version, 
                    price = :price';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->product_id = htmlspecialchars(strip_tags($this->product_id));
            $this->store_id = htmlspecialchars(strip_tags($this->store_id));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->type = htmlspecialchars(strip_tags($this->type));
            $this->model = htmlspecialchars(strip_tags($this->model));
            $this->brand = htmlspecialchars(strip_tags($this->brand));
            $this->color = htmlspecialchars(strip_tags($this->color));
            $this->model_number = htmlspecialchars(strip_tags($this->model_number));
            $this->version = htmlspecialchars(strip_tags($this->version));
            $this->price = htmlspecialchars(strip_tags($this->price));

            // Bind  
            $stmt->bindParam(':product_id', $this->product_id);
            $stmt->bindParam(':store_id', $this->store_id); 
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':type', $this->type);
            $stmt->bindParam(':model', $this->model);
            $stmt->bindParam(':brand', $this->brand);
            $stmt->bindParam(':color', $this->color);
            $stmt->bindParam(':model_number', $this->model_number);
            $stmt->bindParam(':version', $this->version);
            $stmt->bindParam(':price', $this->price);

            //Execute query
            if($stmt->execute()) {
                return true;
            }

            //Print error
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function search($words) {
            $query = 'SELECT
                        store_id, name, description, price 
                    FROM
                        ' . $this->table . ' 
                    WHERE
                        name LIKE ? OR description LIKE ?';
                // prepare query statement
            $stmt = $this->conn->prepare($query);
  
            // sanitize
            $words=htmlspecialchars(strip_tags($words));
            $words = "%{$words}%";

                // bind
            $stmt->bindParam(1, $words);
            $stmt->bindParam(2, $words);
            // execute query
            $stmt->execute();
  
            return $stmt;
        }



        // public function updateProduct() {
        //     $query = 'UPDATE ' . 
        //             $this->table . ' 
        //             SET 
        //                 type = :type, 
        //                 model = :model, 
        //                 brand = :brand, 
        //                 color = :color, 
        //                 model_number = :model_number, 
        //                 version = :version, 
        //                 price = :price
        //             WHERE 
        //                 '


            // Prepare statement
            // $stmt = $this->conn->prepare($query);

            //Clean data
            // $this->type = htmlspecialchars(strip_tags($this->type));
            // $this->model = htmlspecialchars(strip_tags($this->model));
            // $this->brand = htmlspecialchars(strip_tags($this->brand));
            // $this->color = htmlspecialchars(strip_tags($this->color));
            // $this->model_number = htmlspecialchars(strip_tags($this->model_number));
            // $this->version = htmlspecialchars(strip_tags($this->version));
            // $this->price = htmlspecialchars(strip_tags($this->price));

            // Bind
            // $stmt->bindParam(':type', $this->type);
            // $stmt->bindParam(':model', $this->model);
            // $stmt->bindParam(':brand', $this->brand);
            // $stmt->bindParam(':color', $this->color);
            // $stmt->bindParam(':model_number', $this->model_number);
            // $stmt->bindParam(':version', $this->version);
            // $stmt->bindParam(':price', $this->price);

            //Execute query
            // if($stmt->execute()) {
            //     return true;
            // }

            //Print error
        //     printf("Error: %s.\n", $stmt->error);

        //     return false;
        // }

        // public function getLocData() {
        //     // Create query
        //     $query = 'SELECT
        //             a.street as loc1,
        //             a.postcode as loc2,
        //         FROM
        //             ' . $this->table2 . ' a
        //         WHERE
        //             a.address_id 
        }


    