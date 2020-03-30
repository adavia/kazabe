<?php 

namespace App\Providers;

use Slim\Csrf\Guard;
use Psr\Http\Message\ResponseFactoryInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class CsrfServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        'csrf'
    ];

    protected $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function register()
    {
        $this->getContainer()->share('csrf', function () {
            return new Guard($this->responseFactory);
        });
    }
} 