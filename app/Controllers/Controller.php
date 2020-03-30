<?php 

namespace App\Controllers;

use Exception;
use Slim\Views\Twig;
use Valitron\Validator;
use Slim\Flash\Messages;
use App\Mail\Mailer\Mailer;
use App\Exceptions\ValidationException;
use Slim\Interfaces\RouteParserInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Translation\Translator;

class Controller 
{
    protected $view;
    protected $routeParser;
    protected $flash;
    protected $translator;
    protected $mail;
    protected $validator;
    protected $config;

    public function __construct(Twig $view, RouteParserInterface $routeParser, Messages $flash, Translator $translator, Mailer $mail, Validator $validator, $config)
    {   
        $this->view = $view;
        $this->routeParser = $routeParser;
        $this->flash = $flash;
        $this->translator = $translator;
        $this->mail = $mail;
        $this->validator = $validator;
        $this->config = $config;
    }

    public function validate(ServerRequestInterface $request, $rules = [])
    {
        $validator = new Validator(
            $params = $request->getParsedBody()
        );

        $validator->mapFieldsRules($rules);
    
        if (!$validator->validate()) {
            throw new ValidationException(
                $validator->errors(),
                $request->getServerParams()['HTTP_REFERER']
            );
        }

        return $params;
    }
}