<?php 

namespace App\Providers;

use Noodlehaus\Config;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ConfigServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        'config'
    ];

    public function register()
    {
        $this->getContainer()->share('config', function () {
            return new Config(__DIR__ . '/../../config');
        });
    }
} 