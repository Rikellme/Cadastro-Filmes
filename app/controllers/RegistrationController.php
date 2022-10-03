<?php 

namespace app\controllers;

use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\UploadedFileInterface;

use app\models\Film;

$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();

$container->set('upload_directory', __DIR__ . '/uploads');

class RegistrationController extends Controller {
    public function index(Request $request, Response $response, $args) {

        $films = new Film;
        $films = $films->all();

        $this->view('registration', [
            'films' => $films,
            'title' => 'registration'
        ]);

        return $response;
    }
}