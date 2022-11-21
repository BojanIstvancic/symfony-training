<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieFormType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    private $moviesRepository;
    private $entityManager;

    public function __construct(MovieRepository $repository, EntityManagerInterface $em)
    {
        $this->moviesRepository = $repository;
        $this->entityManager = $em;
    }

    #[Route('/movies/create', name: 'create_movie')]
    public function create(Request $request): Response
    // acces user data - use the instance of the request object (Request $request)
    // we will do create method, persist data and redirect
    {
        $movie = new Movie(); // instanciate new moveie
        $form = $this->createForm(MovieFormType::class, $movie); // instanciate the form type

        $form->handleRequest($request); // handle our request

        if ($form->isSubmitted() && $form->isValid()) {
            // perform get and post request 
            // isSubmitted() - put or post request
            // $form->isValid() - if inputed values are valid
            $newMovie = $form->getData(); // get data into the variablesf

            // update image path
            $imagePath = $form->get('imagePath')->getData(); // get image from form

            if ($imagePath) { // test if the image path is set
                $newFileName = uniqid() . '.' . $imagePath->guessExtension();
                // update image name cause user can add multiple images with the same name

                try {  // define try catch to throw exception if something fails
                    $imagePath->move( // move image to different location
                        $this->getParameter('kernel.project_dir') . '/public/uploads', // where to put the image (our folder)
                        $newFileName // add image name
                    );
                } catch (FileException $error) {
                    return new Response($error->getMessage());
                }

                $newMovie->setImagePath('/uploads/' . $newFileName); // set image path
            }

            $this->entityManager->persist($newMovie); // persist entity manager interface
            $this->entityManager->flush(); // flush - execute queries

            return $this->redirectToRoute('movies'); // redirect the user
        }

        return $this->render('/movies/create.html.twig', [
            'form' => $form->createView()
        ]);
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
