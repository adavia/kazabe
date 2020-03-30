<?php 

namespace App\Exceptions;

use Throwable;
use ReflectionClass;
use Slim\Views\Twig;
use Slim\Flash\Messages;
use Slim\Psr7\Factory\ResponseFactory;
use App\Exceptions\ValidationException;
use Slim\Exception\HttpNotFoundException;
use Psr\Http\Message\ServerRequestInterface;

class ExceptionHandler
{
    protected $flash;
    protected $view;
    protected $responseFactory;

    public function __construct(Messages $flash, Twig $view, ResponseFactory $responseFactory)
    {
        $this->flash = $flash;
        $this->view = $view;
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(ServerRequestInterface $request, Throwable $exception)
    {
        if (method_exists($this, $handler = 'handle' . (new ReflectionClass($exception))->getShortName())) {
            return $this->{$handler}($request, $exception);
        }

        throw $exception;
    }

    public function handleHttpNotFoundException(ServerRequestInterface $request, Throwable $exception)
    {
        return $this->view->render(
            $this->responseFactory->createResponse(),
            'errors/404.html'
        )->withStatus(404);
    }

    public function handleValidationException(ServerRequestInterface $request, Throwable $exception)
    {
        $this->flash->addMessage('errors', $exception->getErrors());
            
        return $this->responseFactory
            ->createResponse()
            ->withHeader('Location', $exception->getPath() . '#contact');
    }
}