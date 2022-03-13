<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {    

    $mysqli = new mysqli("127.0.0.1", "root", "", "guiltybit"); 

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('<h1>¡Hola Mundo!</h1>');
        $response->getBody()->write('<p>Bienvenido a mi app</p>');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->get('/elemenprova', function(Request $request, Response $response) {
        $data = array();
        array_push($data, array('name' => 'Manu', 'age' => 39));
        array_push($data, array('name' => 'Chen', 'age' => 40));
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);

    });

    $app->get('/usuarios', function(Request $request, Response $response) use ($mysqli) {     
        $mysqli->real_query("SELECT * FROM redactor");
        $data = [];
        $resultado = $mysqli->use_result();
        while ($fila = $resultado->fetch_assoc()) {
            array_push($data, $fila);
        }

        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);
    });

    $app->redirect('/redd', '/elemenprova', 302);
};
