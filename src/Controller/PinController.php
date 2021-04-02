<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Form\PinType;
use App\Repository\PinRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinController extends AbstractController
{
    
    public function index(PinRepository $pinRepository): Response
    {
        $pin = $pinRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('pin/index.html.twig', [
            'pins' => $pin    
        ]);
    }

    public function show(Pin $pin)
    {

        return $this->render('pin/show.html.twig', [
            'pin'=> $pin
        ]);
    }

    public function create(EntityManagerInterface $em,UserRepository $userRepo, Request $request): Response
    {
        $pin = new Pin; 
        $form = $this->createForm(PinType::class, $pin);

        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()){
            $pin->setUser($this->getUser()); 

            $em->persist($pin); 
            $em->flush(); 

            $this->addFlash('success', 'Pin successfully created'); 

            return $this->redirectToRoute('app_show', 
                ['id'=> $pin->getId()]
            ); 
        }
        return $this->render('pin/create.html.twig', [
            'monFormulaire' => $form->createView() 
        ]); 
    }

    public function edit(Pin $pin, EntityManagerInterface $em, Request $request): Response
    {
        $form = $this->createFormBuilder($pin)
                        ->add('title')
                        ->add('description')
                        ->getForm()
        ;
        $form->handleRequest($request); 
        if($form->isSubmitted() && $form->isValid()){
            $em->flush(); 

            $this->addFlash('success', 'Pin successfully updated!');
            return $this->redirectToRoute('app_index'); 
        }
        return $this->render('pin/edit.html.twig', [
            'monFormulaire' => $form->createView(), 
            'pin' => $pin
        ]); 
    }

    public function delete(Pin $pin, EntityManagerInterface $em): Response
    {
        $em->remove($pin);
        $em->flush(); 
        
        $this->addFlash('danger', 'Pin successfully deleted!'); 

        return $this->redirectToRoute('app_index'); 
    }
}
