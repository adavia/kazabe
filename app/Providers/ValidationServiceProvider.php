<?php 

namespace App\Providers;

use Valitron\Validator;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ValidationServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        'validator'
    ];

    public function register()
    {
        $container = $this->getContainer();

        $config = $container->get('config');

        Validator::langDir(__DIR__ . '/../../resources/validation');
        Validator::lang($_SESSION['lang'] ?? $config->get('app.default_locale'));

        $container->share('validator', function () {
            return new Validator();
        });
    }
} 