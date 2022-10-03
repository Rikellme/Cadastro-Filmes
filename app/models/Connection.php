<?php

namespace app\models;

use PDO;

class Connection {
    public static function connect() {
        $pdo = new PDO("mysql:host=localhost;dbname=films", "root", "");
        
        return $pdo;
    }
}