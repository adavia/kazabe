<?php  

use App\Controllers\HomeController;
use App\Controllers\TranslationController;

$container->add(HomeController::class, function () use($container, $app) {
    return new HomeController(
        $container->get('view'),
        $app->getRouteCollector()->getRouteParser(),
        $container->get('flash'),
        $container->get('translator'),
        $container->get('mail'),
        $container->get('validator'),
        $container->get('config')
    );
});

$container->add(TranslationController::class, function () use($container, $app) {
    return new TranslationController(
        $container->get('view'),
        $app->getRouteCollector()->getRouteParser(),
        $container->get('flash'),
        $container->get('translator'),
        $container->get('mail'),
        $container->get('validator'),
        $container->get('config')
    );
});
