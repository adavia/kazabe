<?php 

namespace App\Controllers;

use App\Mail\Contact;
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController extends Controller
{
    public function index(ServerRequestInterface $request, ResponseInterface $response, $args)
    {   
        $captchaCode = $this->config->get('captcha.frontend_code');
        return $this->view->render($response, 'home/index.html', ['captcha' => $captchaCode]);
    }

    public function contact(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $data = $this->validate($request, [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'message' => ['required']
        ]);
        
        $captchaSecurityCode = $this->config->get('captcha.security_code');
        $recaptcha = new \ReCaptcha\ReCaptcha($captchaSecurityCode);

        $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
            ->verify($request->getParsedBody()['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

        if ($resp->isSuccess()) {
            $this->mail->to('andresi.davia@gmail.com', 'Kazabe Luxury')->send(new Contact($data));
            
            $this->flash->addMessage('status', $this->translator->trans('messages.contact.success'));
            return $response->withHeader('Location', $this->routeParser->urlFor('home') . '#contact');
        } else {
            $this->flash->addMessage('status', $this->translator->trans('messages.contact.fail'));
            return $response->withHeader('Location', $this->routeParser->urlFor('home') . '#contact');
        }
    }
}