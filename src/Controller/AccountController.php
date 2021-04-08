<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use App\Form\UseFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="app_account", methods="GET")
     * 
     */
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    /**
     * @Route("/account/edit", name="app_account_edit", methods="GET|POST")
     */
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        // recuperer l utilisateur
        $user = $this->getUser(); 

        $form = $this->createForm(UseFormType::class, $user); 
        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush(); 

            $this->addFlash('success', 'Account updated successfully'); 
            return $this->redirectToRoute('app_account'); 
        }
        return $this->render('account/edit.html.twig', [
            'form' => $form->createView() 
        ]);
    }
    
    /**
     * @Route("/account/change", name="app_account_change", methods="GET|POST")
     */
    public function change(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em): Response
    {
        // recuperer l utilisateur
        $user = $this->getUser(); 

        $form = $this->createForm(ChangePasswordFormType::class, null,  [
            'current_password_form' => true
        ]);
        
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid())
        {
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $form['plainPassword']->getData()) 
            );
            $em->flush();
            $this->addFlash('success', 'Password updated successfully'); 

            return $this->redirectToRoute('app_account');
        }
        return $this->render('account/changePassword.html.twig', [
            'form' => $form->createView()
        ]); 
    }
}
