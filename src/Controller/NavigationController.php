<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Session\Session;



class NavigationController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index()
    {
        return $this->render('navigation/home.html.twig');
    }

    #[Route('/home', name: 'home')]
    public function membre()
    {
        $hasAccess = $this->isGranted('IS_AUTHENTICATED_FULLY');
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('home/home.html.twig');
    }

    #[Route('/admin', name: 'admin')]
    public function admin(Session $session)
    {
        $user = $this->getUser();

        if($user && in_array('ROLE_ADMIN', $user->getRoles())){
            return $this->render('navigation/admin.html.twig');
        } 

        $session->set("message", "Vous n'avez pas le droit d'acceder à la page admin vous avez été redirigé sur cette page");
        return $this->renderToRoute('home');
    }
}
