<?php
    class StoreName {
    private $conn;
    private $table = 'store';
    private $table2 = 'store_address';

    public $store_id;
    public $address_id;
    public $name;

    // Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    public function uploadStoreName() {
        $query = 'INSERT INTO ' . 
        $this->table . '
            SET
            store_id = :store_id,
            address_id = :address_id, 
            name = :name';
        
        $stmt = $this->conn->prepare($query); 
            //Clean data
            $this->store_id = htmlspecialchars(strip_tags($this->store_id));
            $this->address_id = htmlspecialchars(strip_tags($this->address_id));
            $this->name = htmlspecialchars(strip_tags($this->name));
   
            // Bind
            $stmt->bindParam(':store_id', $this->store_id);
            $stmt->bindParam(':address_id', $this->address_id);
            $stmt->bindParam(':name', $this->name);
   
            //Execute query
            if($stmt->execute()) {
                return true;
            }
   
            //Print error
            printf("Error: %s.\n", $stmt->error);
   
            return false;      
        }
    }