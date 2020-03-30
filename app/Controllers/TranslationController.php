<?php 

namespace App\Controllers;

use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TranslationController extends Controller
{
    public function switch(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        if (isset($args['lang'])) {
            $_SESSION['lang'] = $args['lang'];
        }

        return $response->withHeader('Location', $this->routeParser->urlFor('home'));
    }
}