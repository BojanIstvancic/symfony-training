<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewTwigController extends AbstractController
{
    #[Route('/view_twig', name: 'view_twig')]

    public function index(): Response
    {

        // render the view - this is defined in twig file
        // twig files are located in templates folder
        // add the route
        $movies = ['Man In Black', 'God of War', 'Rush Hour'];

        return $this->render('/view_twig/index.html.twig', [
            'controller_name' => 'ViewTwigController',
            'title' => 'Bojan Istvancic',
            'movies' => $movies
            // pass a custom data
        ]);
    }
}
