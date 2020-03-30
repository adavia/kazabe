<?php 

use App\Exceptions\ExceptionHandler;

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$errorMiddleware->setDefaultErrorHandler(
    new ExceptionHandler(
        $container->get('flash'),
        $container->get('view'),
        $app->getResponseFactory()
    )
);