<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use App\Repository\UserRepository;
use App\Service\OmdbApiConsumer;
use App\Service\Transformer;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Event\MovieRestrictionEvent;

#[Route('/movie')]
class MovieController extends AbstractController
{
    #[Route('/', name: 'app_movie_index', methods: ['GET'])]
    public function index(MovieRepository $movieRepository, UserRepository $userRepository): Response
    {
        return $this->render('movie/index.html.twig', [
            'movies' => $movieRepository->findAll(),
            'users'=> $userRepository->notifyAdministrators(),
        ]);
    }

    #[Route('/admin/new', name: 'app_movie_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($movie);
            $entityManager->flush();

            return $this->redirectToRoute('app_movie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('movie/new.html.twig', [
            'movie' => $movie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_movie_show', methods: ['GET'])]
    public function show(Movie $movie, EventDispatcherInterface $eventDispatcher): Response
    {
        $eventDispatcher->dispatch(new MovieRestrictionEvent($movie));
        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/admin/{id}/edit', name: 'app_movie_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Movie $movie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_movie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('movie/edit.html.twig', [
            'movie' => $movie,
            'form' => $form,
        ]);
    }

    #[Route('/admin/{id}', name: 'app_movie_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Movie $movie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$movie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($movie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_movie_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/title/{title}', name: 'app_movie_api', methods: ['GET'])]
    public function getMovie(string $title,OmdbApiConsumer $omdbApiConsumer): Response
    {
        return $this->render('movie/showapi.html.twig', [
            'movie' => $omdbApiConsumer->getByTitle($title),
        ]);
    }

    #[Route('/import/{title}',name: 'app_movie_import', methods: ['GET'] )]
    public function import(Transformer $transformer, string $title)
    {
        $transformer->persist($title);
        return $this->redirectToRoute('app_movie_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/order/{id}', name: 'app_movie_order', methods: ['GET'])]
    public function orderMovie(Movie $movie): Response
    {
        return $this->render('movie/order.html.twig', [
            'movie' => $movie,
        ]);
    }


}
