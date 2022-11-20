<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    private $moviesRepository;

    public function __construct(MovieRepository $repository)
    {
        $this->moviesRepository = $repository;
    }

    #[Route('/movies',  methods: ['GET'],  name: 'movies')]
    public function index(): Response
    {
        return $this->render('/movies/index.html.twig', [
            'movies' => $this->moviesRepository->findAll()
        ]);
    }

    #[Route('/movies/{id}',  methods: ['GET'],  name: 'movie')]
    public function show($id): Response
    {
        return $this->render('/movies/show.html.twig', [
            'movie' => $this->moviesRepository->find($id)
        ]);
    }
}
