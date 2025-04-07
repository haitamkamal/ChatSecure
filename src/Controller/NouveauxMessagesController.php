<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ArticlesType; 
use App\Entity\Articles;

final class NouveauxMessagesController extends AbstractController
{
    #[Route('/nouveaux/messages', name: 'app_nouveaux_messages')]
    public function new(Request $request, EntityManagerInterface $manager): Response 
    {
        $articles = new Articles();

        $form = $this->createForm(ArticlesType::class,$articles);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($articles);
            $manager->flush();

            return $this->redirectToRoute('app_user'); 
        }

        $form = $this->createForm(ArticlesType::class);
        return $this->render('nouveaux_messages\index.html.twig', [
            'form' => $form->createView(), 
        ]);
    }
    #[Route('/Message/{id<\d+>}/Delete',name:'Delete_message')]
    public function delete(Request $request,Articles $articles, EntityManagerInterface $manager ): response
    { 
            
        if ($request->isMethod('POST')) {

            $manager->remove($articles);
            $manager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this -> render ('nouveaux_messages\delete.html.twig',[
            'id'=>$articles ->getId(),
        ]);
    }
}
