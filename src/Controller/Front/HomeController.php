<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/front/home', name: 'front_home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('front/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/update/{id}', name: 'update')]
    public function update(): Response
    {
        return $this->render('front/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
