<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavBarController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('navbar.html.twig');
    }
}
