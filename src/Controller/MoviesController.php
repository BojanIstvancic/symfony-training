<?php

namespace App\Controller;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/movies', name: 'movies')]

    public function index(): Response
    {
        // BuiltInQuerie
        // findAll() -> SELECT * FROM 'movies'
        // find(1) -> SELECT * FROM 'movies' WHERE id=1
        // findBy([], ['id' => 'DESC']) -> SELECT * FROM 'movies' ORDER BY id DESC
        // findOneBy(['id' => 7, 'title' => 'The Dark Knight'], ["id" => 'DESC']); 
        // SELECT * FROM 'movies' WHERE id = 6 AND title = 'The Dark Knight' ORDER BY id DESC
        // count([]) -> count amount of elements in table
        // count(["id" => 7] -> SELECT COUNT() from movies WHERE  id = 1
        // getClassName(); -> get EntityName

        // we can also create custom queries

        $repository = $this->em->getRepository(Movie::class);
        $movies = $repository->getClassName();
        dd($movies); // var_dump for symfony

        return $this->render('/movies/index.html.twig');
    }
}
