<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


class UserController extends AbstractController
{
    #[Route('/user', name: 'create_user')]
    public function createUser(ManagerRegistry $doctrine):Response
    {  	
        $entityManager = $doctrine->getManager();

        $user = new User();
        $user->setEmail('pd@gmail.com');
        $user->setUsername('pold');
        $user->setPassword('test');

        $entityManager->persist($user);

        $entityManager->flush();

        return new Response('Saved new user with id '.$user->getId());
    }

    #[Route('/user/{id}', name: 'user_show')]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $user = $doctrine->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        return new Response($user->getUsername().' Found ! ');

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }

    #[Route('/user/edit/{id}', name: 'user_edit')]
    public function update(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $user->SetUsername('test');
        $entityManager->flush();

        return $this->redirectToRoute('user_show', [
            'id' => $user->getId()
        ]);
    }
    #[Route('/user/delete/{id}', name: 'user_delete')]
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return new Response('Deleted user! ');

    }

}
