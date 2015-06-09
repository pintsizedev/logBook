<?php
/**
 * Class DBManager
 *
 * This class is used for managing any database code, such as inputting to the database.
 *
 * @property MongoClient connection The connection to the mongo database
 * @property MongoDB db The Database table that the class is using
 *
 */
class DBManager {

    private $connection;
    private $db;

    function __construct() {
        $this->connection = new \MongoClient();
        $this->db = $this->connection->selectDB("logBook");
    }

    /**
     * Adds a post to the "posts" collection in the database
     *
     * @param array $data The data to be added to the collection
     */
    function addPost(array $data) {
        $collection = $this->db->selectCollection("posts");
        $collection->insert($data);
    }

    /**
     * Gets the Database table in use by the DBManager
     *
     * @return MongoDB The database table in use by the DBManager
     */
    function getDb(){
        return $this->db;
    }
}