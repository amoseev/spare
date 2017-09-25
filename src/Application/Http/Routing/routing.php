<?php



/** @var Slim\App $app */

$app->group('', function () use ($app) {

    $app->group('', function () use ($app) {

        // car
        $app->group('/car', function () use ($app) {
            $app->get('/index[/]', \Application\Http\Controllers\Car\CarController::class);
            $app->post('/create[/]', \Application\Http\Controllers\Car\CarController::class . ':action_create');
            $app->post('/delete/{carId}[/]', \Application\Http\Controllers\Car\CarController::class . ':action_delete');
            $app->post('/update/{carId}[/]', \Application\Http\Controllers\Car\CarController::class . ':action_update');
        });


    })->add(\Application\Http\Middleware\Web\WebHandleExceptionMiddleware::class);
});

