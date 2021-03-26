<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
