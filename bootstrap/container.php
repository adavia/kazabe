<?php 

use App\Providers\CsrfServiceProvider;
use App\Providers\LangServiceProvider;
use App\Providers\MailServiceProvider;
use App\Providers\ViewServiceProvider;
use App\Providers\FlashServiceProvider;
use App\Providers\ConfigServiceProvider;
use App\Providers\ValidationServiceProvider;

$container->addServiceProvider(
    new ConfigServiceProvider()
);

$container->addServiceProvider(
    new ValidationServiceProvider()
);

$container->addServiceProvider(
    new MailServiceProvider()
);

$container->addServiceProvider(
    new LangServiceProvider()
);

$container->addServiceProvider(
    new ViewServiceProvider(
        $app->getRouteCollector()->getRouteParser()
    )
);

$container->addServiceProvider(
    new FlashServiceProvider()
);

$container->addServiceProvider(
    new CsrfServiceProvider(
        $app->getResponseFactory()
    )
);