<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomePageController extends AbstractController
{
  #[Route('/home')]
  public function home(): Response
  {
    return $this->render('/home/home.html.twig', [
      'title' => 'Home Page Twitter',
      'subtitle' => 'Welcome to the home page',
    ]);
  }
}
