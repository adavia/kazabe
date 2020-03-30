<?php 

namespace App\Providers;

use App\Mail\Mailer\Mailer;
use League\Container\ServiceProvider\AbstractServiceProvider;

class MailServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        'mail'
    ];

    public function register()
    {
        $container = $this->getContainer();

        $config = $container->get('config');
        $view = $container->get('view');

        $transport = (new \Swift_SmtpTransport($config->get('mail.host'), $config->get('mail.port'), 'tls'))
            ->setUsername($config->get('mail.username'))
            ->setPassword($config->get('mail.password'));

        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        $container->share('mail', function () use ($mailer, $view, $config) {
            $name = $config->get('mail.from.name');
            $address = $config->get('mail.from.address');

            return (new Mailer($mailer, $view))->alwaysFrom($address, $name);
        });
    }
} 