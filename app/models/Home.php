<?php 

namespace app\models;

use app\models\Connection;

class Home {
    protected $connect;

    public function __construct() {
        $this->connect = Connection::connect();
    }

    public function all() {
        $sql = "SELECT * FROM tbfilm ORDER BY evaluationFilm DESC";
        $sql = $this->connect->query($sql);
        $sql->execute();

        return $sql->fetchAll();
    }
}