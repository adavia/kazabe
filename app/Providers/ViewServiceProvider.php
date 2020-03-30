<?php 

namespace App\Providers;

use Slim\Views\Twig;
use App\Views\CsrfExtension;
use Slim\Views\TwigExtension;
use Slim\Psr7\Factory\UriFactory;
use Slim\Views\TwigRuntimeLoader;
use App\Views\TranslatorExtension;
use Slim\Interfaces\RouteParserInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ViewServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        'view'
    ];

    public function __construct(RouteParserInterface $routeParser)
    {
        $this->routeParser = $routeParser;
    }

    public function register()
    {
        $container = $this->getContainer();

        $container->add('view', function () use($container) {
            $twig = Twig::create(__DIR__ . '/../../resources/views', [
                'cache' => false
            ]);

            $twig->addRuntimeLoader(
                new TwigRuntimeLoader(
                    $this->routeParser,
                    (new UriFactory)->createFromGlobals($_SERVER)
                )
            );

            $this->registerGlobals($twig);

            $twig->addExtension(new TwigExtension());
            $twig->addExtension(new CsrfExtension($container->get('csrf')));
            $twig->addExtension(new TranslatorExtension($container->get('translator')));

            return $twig;
        });
    }

    protected function registerGlobals(Twig $twig) 
    {
        $container = $this->getContainer();

        $twig->getEnvironment()->addGlobal('status', $container->get('flash')->getFirstMessage('status'));
        $twig->getEnvironment()->addGlobal('errors', $container->get('flash')->getFirstMessage('errors'));
        $twig->getEnvironment()->addGlobal('field', $container->get('flash')->getFirstMessage('field'));
    }
} 