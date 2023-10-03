<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;

class MovieController extends AbstractController
{

    const  movies = [
        [
            'id'=>'1',
            'titre' => 'OPPENHEIMER',
            'categories'=>'Biopic, Historique, Thriller',
            'date'=>'19 juillet 2023'],
        [
            'id'=>'2',
            'titre' => 'OPPENHEIMER',
            'categories'=>'Biopic, Historique, Thriller',
            'date'=>'19 juillet 2023'],
        [
            'id'=>'3',
            'titre' => 'OPPENHEIMER',
            'categories'=>'Biopic, Historique, Thriller',
            'date'=>'19 juillet 2023']
    ];


    #[Route('/movie/{id}', name: 'movie')]
    public function index(int $id): Response
    {
        if(!isset(self::movies[$id])) {
            throw $this->createNotFoundException();
        }

        return $this->render('movie_details.html.twig', [
            'id' => $id,
            'movie' => self::movies[$id],
        ]);
    }

    #[Route('/movies', name: 'movies')]
    public function showAll(): Response
    {

        return $this->render('movie_list.html.twig', [
            'movies' => self::movies,
        ]);
    }

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
}