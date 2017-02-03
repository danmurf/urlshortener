<?php
namespace App\Library;

use App\Interfaces\DatabaseInterface;
use PDO;

 class Database implements DatabaseInterface
 {
     private $connection;
     private $statement;

     public function __construct() {
         $this->connect();
     }

     /**
      * Connect to the database
      * @method connect
      */
     private function connect() {
         $destination = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";

         $options = [
             PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
             PDO::ATTR_EMULATE_PREPARES   => false,
         ];

         $this->connection = new PDO($destination, DB_USERNAME, DB_PASSWORD, $options);
     }

     /**
      * Run a database query
      * @method query
      * @param  string $sql        An SQL query
      * @param  array  $parameters An array of data to be swapped with '?' in the SQL query
      * @return object             The database object
      */
     public function query($sql, $parameters = array()) {
         $this->statement = $this->connection->prepare($sql);

         if (sizeof($parameters) > 0) {
             $position = 1;
             foreach ($parameters as $parameter) {
                 $this->statement->bindParam($position, $parameters[$position-1]);
                 $position++;
             }
         }

         $this->statement->execute();

         return $this;
     }

     /**
      * Fetch the result of a query
      * @method result
      * @return array The query result in an array
      */
     public function result() {
         if (!is_null($this->statement)) {
             return $this->statement->fetch();
         }
         else {
             return false;
         }
     }

     /**
      * Returns the number of affected rows of a query
      * @method affectedRows
      * @return int The number of rows affected
      */
     public function affectedRows() {
         if (!is_null($this->statement)) {
             return $this->statement->rowCount();
         }
         else {
             return false;
         }
     }

     /**
      * Start a database transaction
      * @method startTransaction
      */
     public function startTransaction() {
         $this->connection->beginTransaction();
     }

     /**
      * Cancel and rollback any changes since the start of the transaction
      * @method cancelTransaction
      */
     public function cancelTransaction() {
         $this->connection->rollBack();
     }

     /**
      * Commit the changes since the start of the transaction to the database
      * @method commitTransaction
      */
     public function commitTransaction() {
         $this->connection->commit();
     }
 }
