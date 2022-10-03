<?php 

namespace app\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use app\models\Film;

class FilmsController extends Controller {
    public function index(Request $request, Response $response, $args) {

        $films = new Film;
        $films = $films->all();

        // var_dump($films);

        $this->view('films', [
            'films' => $films,
            'title' => 'Filmes'
        ]);

        return $response;
    }
}