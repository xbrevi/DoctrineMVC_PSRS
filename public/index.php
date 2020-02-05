<?php

require __DIR__ . '/../vendor/autoload.php';

use Alura\Cursos\Controller\FormularioInsercao;
use Alura\Cursos\Controller\ListarCursos;
use Alura\Cursos\Controller\Persistencia;
use Alura\Cursos\Controller\FormularioLogin;

use Nyholm\Psr7Server\ServerRequestCreator;


$caminho = $_SERVER['PATH_INFO'];
$rotas = require __DIR__ . '/../config/routes.php';


if (!array_key_exists($caminho, $rotas)) {
    http_response_code(404);
    exit();
}    

session_start();

/*
$RotaDeLogin = stripos($caminho, 'login');
if (!isset($_SESSION['logado']) && $RotaDeLogin === false) {
    header('Location: /login');
    exit();
}
*/

$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();
$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UrlFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory // StreamFactory
);

$request = $creator->fromGlobals();

$classeControladora = $rotas[$caminho];
/** @var \Psr\Container\ContainerInterface $container */
$container = require __DIR__ . '/../config/dependencies.php';

/** @var RequestHandlerInterface $controlador */
$controlador = $container->get($classeControladora);
$resposta = $controlador->handle($request);


foreach ($resposta->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}
echo $resposta->getBody();










