<?php
class DBManager {
    private $connection;
    private $db;

    function __construct() {
        $this->connection = new \MongoClient();
        $this->db = $this->connection->logBook;
    }

    function addPost(array $data) {
        $collection = $this->db->posts;
        $collection->insert($data);
    }

    function getDb(){
        return $this->db;
    }
}