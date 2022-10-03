<?php 

namespace app\models;

use app\models\Connection;

class Film {
    protected $connect;

    public function __construct() {
        $this->connect = Connection::connect();
    }

    public function all() {
        $sql = "SELECT * FROM tbfilm ORDER BY id DESC";
        $sql = $this->connect->query($sql);
        $sql->execute();

        return $sql->fetchAll();
    }

    public function insert($dadosPost, $filename) {
        if(empty($dadosPost['nameFilm']) OR empty($dadosPost['yearFilm']) OR empty($dadosPost['evaluationFilm'])) {
            throw new Exception("Preencha todos os campos");
            return false;
        }

        if($dadosPost['evaluationFilm'] < 0 || $dadosPost['evaluationFilm'] > 10) {
            echo '<script>alert("SEU CADASTRO FALHOU!\n\nSua avaliação precisa ser um número entre 0 a 10\nVolte e tente novamente!");</script>';
            return false;
        }

        $sql = "INSERT INTO tbfilm (nameFilm, imageFilm, nameDirector, yearFilm, evaluationFilm) VALUES(:nomeFilme, :imagemFilme, :nomeDiretor, :anoFilme, :avaliacaoFilme)";
        $sql = $this->connect->prepare($sql);
        $sql->bindValue(':nomeFilme', $dadosPost['nameFilm']);
        $sql->bindValue(':imagemFilme', $filename);
        $sql->bindValue(':nomeDiretor', $dadosPost['nameDirector']);
        $sql->bindValue(':anoFilme', $dadosPost['yearFilm']);
        $sql->bindValue(':avaliacaoFilme', $dadosPost['evaluationFilm']);
        $res = $sql->execute();

        if($res == 0) {
            throw new Exception("Falha ao inserir filme");

            return false;
        }

        return true;

    }
}