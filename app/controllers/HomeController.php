<?php 

namespace app\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use app\models\Home;

class HomeController extends Controller {
    public function index(Request $request, Response $response, $args) {

        $films = new Home;
        $films = $films->all();

        $this->view('home', [
            'films' => $films,
            'title' => 'home'
        ]);

        return $response;
    }
}