<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\Persistence\ObjectManager;
use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;

class MovieCopyController extends AbstractController
{





    #[Route('/categories', name: 'categories')]
    public function categories(): Response
    {
        return $this->render('movie_categories.html.twig');
    }

    #[Route('/rechercher', name: 'rechercher')]
    public function rechercher(): Response
    {
        return $this->render('movie_rechercher.html.twig');
    }

    #[Route('/movie/{id}', name: 'movie', methods: 'GET')]
    public function index(int $id, MovieRepository $movieRepository): Response
    {

        $movie = $movieRepository->find($id);

        return $this->render('movie_details.html.twig', [
            'id' => $id,
            'movie' => $movie,
        ]);
    }
    #[Route('/movies', name: 'movies', methods:'GET')]
    public function all(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();

        return $this->render('movie_list.html.twig', [
            'movies' => $movies
        ]);
    }


}