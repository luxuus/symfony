<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends AbstractController
{
    #[Route('/hello/{name}', name: 'hello', defaults:['name' => 'inconnu'])]
    public function index(string $name): Response
    {
        return $this->render('hello_world/indexdddad.html.twig', [
            'controller_name' => 'HelloWorldController',
            'name' => $name,
        ]);
    }
}
