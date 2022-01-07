<?php
    class Store {
        private $conn;
        private $table = 'product';
        private $table2 = 'store_address';
        private $table3 = 'store';
        //create uuid in javascript
        public $a_name;
        public $address_id;
        public $street;
        public $city;
        public $county;
        public $postcode;
        
        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }    
        
        public function uploadStore() {
            
            $query = 'INSERT INTO ' . 
            $this->table2 . '
                SET 
                address_id = :address_id, 
                street = :street, 
                city = :city, 
                county = :county,
                postcode = :postcode';
        
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->address_id = htmlspecialchars(strip_tags($this->address_id));
            $this->street = htmlspecialchars(strip_tags($this->street));
            $this->city = htmlspecialchars(strip_tags($this->city));
            $this->county = htmlspecialchars(strip_tags($this->county));
            $this->postcode = htmlspecialchars(strip_tags($this->postcode));

            // Bind
            $stmt->bindParam(':address_id', $this->address_id);
            $stmt->bindParam(':street', $this->street);
            $stmt->bindParam(':city', $this->city);
            $stmt->bindParam(':county', $this->county);
            $stmt->bindParam(':postcode', $this->postcode);

            //Execute query
            if($stmt->execute()) {
                return true;
            }

            //Print error
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    public function read_single() {
          // Create query
          $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
                                    FROM ' . $this->table . ' p
                                    LEFT JOIN
                                      categories c ON p.category_id = c.id
                                    WHERE
                                      p.id = ?
                                    LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->title = $row['title'];
          $this->body = $row['body'];
          $this->author = $row['author'];
          $this->category_id = $row['category_id'];
          $this->category_name = $row['category_name'];
    }        
        public function getAddress() {
            $query = 'SELECT
                        s.name as a_name, a.address_id, a.street, a.city, a.county, a.postcode 
                    FROM 
                        ' . $this->table2 . ' a
                        RIGHT JOIN
                            store s ON a.address_id = s.address_id
                        WHERE
                            s.store_id LIKE ?
                            LIMIT 0,1';
            // prepare query statement
            $stmt = $this->conn->prepare($query);
        
            // Bind ID
            $stmt->bindParam(1, $this->address_id);

            // Execute query
            $stmt->execute();
        
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
                  // Set properties

            $this->street = $row['street'];
            $this->city = $row['city'];
            $this->county = $row['county'];
            $this->postcode = $row['postcode'];           
            $this->a_name = $row['a_name'];                    
            
        }


    }