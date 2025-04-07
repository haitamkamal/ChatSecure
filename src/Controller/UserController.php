<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(ArticlesRepository $repository): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'Articles'=>$repository->findAll()
        ]);
    }
}
