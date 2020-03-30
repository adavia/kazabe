<?php 

namespace App\Providers;

use Noodlehaus\Config;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;
use League\Container\ServiceProvider\AbstractServiceProvider;

class LangServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        'translator'
    ];

    public function register()
    {
        $container = $this->getContainer();

        $config = $container->get('config');

        $translator = new Translator($_SESSION['lang'] ?? $config->get('app.default_locale'));
        $translator->setFallbackLocales([$config->get('app.default_locale')]);
        $translator->addLoader('array', new ArrayLoader);

        $finder = new Finder;
        $langDirs = $finder->directories()->ignoreUnreadableDirs()->in(__DIR__ . '/../../resources/lang');

        foreach ($langDirs as $dir) {
            $translator->addResource(
                'array',
                (new Config($dir))->all(),
                $dir->getRelativePathName()
            );
        }

        $container->share('translator', function () use ($translator) {
            return $translator;
        });
    }
} 