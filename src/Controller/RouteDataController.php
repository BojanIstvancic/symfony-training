<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RouteDataController extends AbstractController
{
    #[Route('/route_data/{name}', name: 'route_data', defaults: ['name' => null], methods: ['GET'])]
    // endpoint - '/movies/${variable}' 
    // name - whatever
    // default['key' => value] - default method 
    // methods['GET"] - list of available methods

    public function index($name): Response
    {
        // ### return data

        return $this->json([
            'movie' => $name,
            'path' => 'src/Controller/MoviesController.php',
        ]);
    }
}
