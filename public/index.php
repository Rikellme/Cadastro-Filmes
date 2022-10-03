<?php

// require "../bootstrap.php";

use app\models\Film;

use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();

$container->set('upload_directory', __DIR__ . '/uploads');

AppFactory::setContainer($container);
$app = AppFactory::create();

// Add routes
$app->get('/', 'app\controllers\HomeController:index');
$app->get('/films', 'app\controllers\FilmsController:index');
$app->get('/registration', 'app\controllers\RegistrationController:index');
$app->post('/teste', function (ServerRequestInterface $request, ResponseInterface $response) {
    $directory = $this->get('upload_directory');
    $uploadedFiles = $request->getUploadedFiles();

    $uploadedFile = $uploadedFiles['imageFilm'];
    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
        $filename = moveUploadedFile($directory, $uploadedFile);
    }

    $parameters = (array)$request->getParsedBody();

    try {
        $films = new Film;
        $films = $films->insert($parameters, $filename);

        echo '<script>location.href="/films";</script>';
    } catch(Exception $e) {
        return $e->getMessage();
    }

    
    return $response;
});

function moveUploadedFile(string $directory, UploadedFileInterface $uploadedFile)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

    // see http://php.net/manual/en/function.random-bytes.php
    $basename = bin2hex(random_bytes(8));
    $filename = sprintf('%s.%0.8s', $basename, $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}


$app->addErrorMiddleware(true, true, true);
// Run app
$app->run();

