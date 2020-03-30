<?php 

namespace App\Mail\Mailer;

use \Swift_Mailer;
use Slim\Views\Twig;
use App\Mail\Mailer\MessageBuilder;
use App\Mail\Mailer\Contracts\MailableContract;

class Mailer
{
    protected $mailer;
    protected $view;
    protected $from = [];

    public function __construct(Swift_Mailer $mailer, Twig $view)
    {
        $this->mailer = $mailer;
        $this->view = $view;
    }

    public function alwaysFrom($address, $name = null)
    {
        $this->from = compact('address', 'name');

        return $this;
    }

    public function to($address, $name = null)
    {
        return (new PendingMailable($this))->to($address, $name);
    }

    public function send($view, $viewData = [], Callable $callback = null)       
    {
        if ($view instanceof MailableContract) {
            return $this->sendMailable($view);
        }
        
        $message = $this->buildMessage();

        call_user_func($callback, $message);

        $message->body($this->parseView($view, $viewData));

        $this->mailer->send($message->getSwiftMessage());
    }

    protected function sendMailable(Mailable $mailable)
    {
        return $mailable->send($this);
    }

    protected function buildMessage()
    {
        return (new MessageBuilder(new \Swift_Message))
            ->from($this->from['address'], $this->from['name']);
    }

    protected function parseView($view, $viewData)
    {
        return $this->view->fetch($view, $viewData);
    }
}