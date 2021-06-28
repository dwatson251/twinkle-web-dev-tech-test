<?php

use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Twinkl\Core\Exception\ExceptionExt;
use Twinkl\Dashboard\Controller\DashboardController;
use Twinkl\Dashboard\Controller\DashboardUserController;

try {
    $request = Request::createFromGlobals();
    $router = new Router(new Dispatcher());
    
    $router->resource('dashboard/users', DashboardUserController::class);
    
    $router->any('/', [DashboardController::class, 'index']);
    
    $router
        ->dispatch($request)
        ->send();
} catch (Exception $ex) {
    throw new ExceptionExt(
        "Routing failed for: {$request->getMethod()} {$request->url()}.",
        $ex->getCode(),
        $ex->getMessage(),
        null,
        $ex
    );
}


