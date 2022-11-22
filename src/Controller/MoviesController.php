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
    private $moviesRepository; // connect to movies repository
    private $entityManager;

    public function __construct(MovieRepository $repository, EntityManagerInterface $em)
    {
        $this->moviesRepository = $repository;
        $this->entityManager = $em;
    }

    #[Route('/movies/edit/{id}', name: 'edit_movie')]
    public function edit($id, Request $request): Response
    {
        $movie = $this->moviesRepository->find($id); // find the specific movie
        $form = $this->createForm(MovieFormType::class, $movie);
        $form->handleRequest($request);

        $imagePath = $form->get('imagePath')->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            if ($imagePath) {
                if ($movie->getImagePath() !== null) { // if image doesn't exist
                    if (file_exists(
                        $this->getParameter('kernel.project_dir') . $movie->getImagePath() // if file exists
                    )) {
                        $this->GetParameter('kernel.project_dir') . $movie->getImagePath(); // get image path
                    }
                    $newFileName = uniqid() . '.' . $imagePath->guessExtension();


                    try {  // define try catch to throw exception if something fails
                        $imagePath->move( // move image to different location
                            $this->getParameter('kernel.project_dir') . '/public/uploads', // where to put the image (our folder)
                            $newFileName // add image name
                        );
                    } catch (FileException $error) {
                        return new Response($error->getMessage());
                    }

                    $movie->setImagePath('/uploads/' . $newFileName);
                    $this->entityManager->flush();
                    return $this->redirectToRoute('movies');
                }
            } else {
                $movie->setTitle($form->get('title')->getData());
                $movie->setYear($form->get('year')->getData());
                $movie->setDescription($form->get('description')->getData());

                $this->entityManager->flush();
                return $this->redirectToRoute('movies');
            }
        }

        return $this->render('/movies/edit.html.twig', [
            'movie' => $movie, // pass movie data
            'form' => $form->createView()
        ]);
    }

    #[Route('/movies/create', name: 'create_movie')]
    public function create(Request $request): Response
    // acces the data that user pass using the inputs instance of the request object - Request $request
    {
        $movie = new Movie(); // instanciate new movie cause we will create movie object
        $form = $this->createForm(MovieFormType::class, $movie);
        // instanciate the form type using the movie Object (Entity)

        $form->handleRequest($request);
        // handle our request + persist data

        if ($form->isSubmitted() && $form->isValid()) {
            // perform get and post request 
            // isSubmitted() - PUT OR POST REQUEST
            // $form->isValid() - if inputed values are valid
            $newMovie = $form->getData(); // get data into the variables - GET REQUEST

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
            'form' => $form->createView() // display form
        ]);
    }

    #[Route('/movies',  methods: ['GET'],  name: 'movies')]
    public function index(): Response
    {
        return $this->render('/movies/index.html.twig', [
            'movies' => $this->moviesRepository->findAll() // pull all data from movie Repository
        ]);
    }

    #[Route('/movies/delete/{id}',  methods: ['GET', 'DELETE'],  name: 'delete_movie')]
    public function delete($id): Response
    {
        $movie = $this->moviesRepository->find($id);
        $this->entityManager->remove($movie);
        $this->entityManager->flush();

        return $this->redirectToRoute('movies');
    }

    #[Route('/movies/{id}',  methods: ['GET'],  name: 'show_movie')]
    public function show($id): Response
    {
        return $this->render('/movies/show.html.twig', [
            'movie' => $this->moviesRepository->find($id)
        ]);
    }
}
